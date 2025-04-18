<?php

namespace Spinen\Halo\Support;

use BadMethodCallException;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection as LaravelCollection;
use Illuminate\Support\Str;
use Illuminate\Support\Traits\Conditionable;
use Spinen\Halo\Action;
use Spinen\Halo\Agent;
use Spinen\Halo\Appointment;
use Spinen\Halo\Article;
use Spinen\Halo\Asset;
use Spinen\Halo\AssetType;
use Spinen\Halo\Attachment;
use Spinen\Halo\Client;
use Spinen\Halo\Concerns\HasClient;
use Spinen\Halo\Contract;
use Spinen\Halo\Exceptions\InvalidRelationshipException;
use Spinen\Halo\Exceptions\ModelNotFoundException;
use Spinen\Halo\Exceptions\NoClientException;
use Spinen\Halo\Exceptions\TokenException;
use Spinen\Halo\Invoice;
use Spinen\Halo\Item;
use Spinen\Halo\Opportunity;
use Spinen\Halo\Organisation;
use Spinen\Halo\Outcome;
use Spinen\Halo\Priority;
use Spinen\Halo\Project;
use Spinen\Halo\Quote;
use Spinen\Halo\Report;
use Spinen\Halo\Site;
use Spinen\Halo\Sla;
use Spinen\Halo\SoftwareLicence;
use Spinen\Halo\Status;
use Spinen\Halo\Supplier;
use Spinen\Halo\Team;
use Spinen\Halo\Ticket;
use Spinen\Halo\TicketType;
use Spinen\Halo\User;
use Spinen\Halo\Webhook;
use Spinen\Halo\WebhookEvent;
use Spinen\Halo\Workday;

/**
 * Class Builder
 *
 * @property Agent $agent
 * @property Client $client
 * @property Collection<int, Action> $actions
 * @property Collection<int, Agent> $agents
 * @property Collection<int, Appointment> $appointments
 * @property Collection<int, Article> $articles
 * @property Collection<int, AssetType> $asset_types
 * @property Collection<int, Asset> $assets
 * @property Collection<int, Attachment> $attachments
 * @property Collection<int, Client> $clients
 * @property Collection<int, Contract> $contracts
 * @property Collection<int, Invoice> $invoices
 * @property Collection<int, Item> $items
 * @property Collection<int, Opportunity> $opportunities
 * @property Collection<int, Organisation> $organisations
 * @property Collection<int, Priority> $priorities
 * @property Collection<int, Project> $projects
 * @property Collection<int, Quote> $quotes
 * @property Collection<int, Report> $reports
 * @property Collection<int, Site> $sites
 * @property Collection<int, Sla> $slas
 * @property Collection<int, SoftwareLicence> $software_licences
 * @property Collection<int, Status> $statuses
 * @property Collection<int, Supplier> $suppliers
 * @property Collection<int, Team> $teams
 * @property Collection<int, TicketType> $ticket_types
 * @property Collection<int, Ticket> $tickets
 * @property Collection<int, User> $users
 * @property Collection<int, WebhookEvent> $webhook_events
 * @property Collection<int, Webhook> $webhooks
 * @property Collection<int, Workday> $workdays
 * @property User $user
 *
 * @method self actions()
 * @method self agents()
 * @method self appointments()
 * @method self articles()
 * @method self asset_types()
 * @method self assets()
 * @method self attachments()
 * @method self clients()
 * @method self contracts()
 * @method self invoices()
 * @method self items()
 * @method self opportunities()
 * @method self organisations()
 * @method self outcomes()
 * @method self priorities()
 * @method self projects()
 * @method self quotes()
 * @method self reports()
 * @method self search($for)
 * @method self sites()
 * @method self slas()
 * @method self software_licences()
 * @method self statuses()
 * @method self suppliers()
 * @method self teams()
 * @method self ticket_types()
 * @method self tickets()
 * @method self users()
 * @method self webhook_events()
 * @method self webhooks()
 * @method self workdays()
 */
class Builder
{
    use Conditionable;
    use HasClient;

    /**
     * Class to cast the response
     */
    protected string $class;

    /**
     * Debug Guzzle calls
     */
    protected bool $debug = false;

    /**
     * Model instance
     */
    protected Model $model;

    /**
     * Parent model instance
     */
    protected ?Model $parentModel = null;

    /**
     * Map of potential parents with class name
     *
     * @var array
     */
    protected $rootModels = [
        'actions' => Action::class,
        'agents' => Agent::class,
        'appointments' => Appointment::class,
        'articles' => Article::class,
        'asset_types' => AssetType::class,
        'assets' => Asset::class,
        'attachments' => Attachment::class,
        'clients' => Client::class,
        'contracts' => Contract::class,
        'invoices' => Invoice::class,
        'items' => Item::class,
        'opportunities' => Opportunity::class,
        'organisations' => Organisation::class,
        'outcomes' => Outcome::class,
        'priorities' => Priority::class,
        'projects' => Project::class,
        'quotes' => Quote::class,
        'reports' => Report::class,
        'sites' => Site::class,
        'slas' => Sla::class,
        'software_licences' => SoftwareLicence::class,
        'statuses' => Status::class,
        'suppliers' => Supplier::class,
        'teams' => Team::class,
        'ticket_types' => TicketType::class,
        'tickets' => Ticket::class,
        'users' => User::class,
        'webhook_events' => WebhookEvent::class,
        'webhooks' => Webhook::class,
        'workdays' => Workday::class,
    ];

    /**
     * Properties to filter the response
     */
    protected array $wheres = [];

    /**
     * Magic method to make builders for root models
     *
     * @throws BadMethodCallException
     * @throws ModelNotFoundException
     * @throws NoClientException
     */
    public function __call(string $name, array $arguments)
    {
        if (! isset($this->parentModel) && array_key_exists($name, $this->rootModels)) {
            return $this->newInstanceForModel($this->rootModels[$name]);
        }

        // Alias search or search_anything or searchAnything to where(search|search_anything, for)
        if (Str::startsWith($name, 'search')) {
            return $this->where(...array_merge([Str::of($name)->snake()->toString()], $arguments));
        }

        throw new BadMethodCallException(sprintf('Call to undefined method [%s]', $name));
    }

    /**
     * Magic method to make builders appears as properties
     *
     * @throws GuzzleException
     * @throws InvalidRelationshipException
     * @throws ModelNotFoundException
     * @throws NoClientException
     * @throws TokenException
     */
    public function __get(string $name): Collection|Model|null
    {
        return match (true) {
            $name === 'agent' => $this->newInstanceForModel(Agent::class)
                ->get(extra: 'me')
                ->first(),
            $name === 'client' => $this->newInstanceForModel(Client::class)
                ->get(extra: 'me')
                ->first(),
            $name === 'user' => $this->newInstanceForModel(User::class)
                ->get(extra: 'me')
                ->first(),
            ! $this->parentModel && array_key_exists($name, $this->rootModels) => $this->{$name}()
                ->get(),
            default => null,
        };
    }

    /**
     * Create instance of class and save via API
     *
     * @throws InvalidRelationshipException
     */
    public function create(array $attributes): Model
    {
        return tap(
            $this->make($attributes),
            fn (Model $model): bool => $model->save()
        );
    }

    /**
     * Set debug on the client
     *
     * This is reset to false after the request
     */
    public function debug(bool $debug = true): self
    {
        $this->debug = $debug;

        return $this;
    }

    /**
     * Delete specific instance of class
     *
     * @throws NoClientException
     * @throws TokenException
     */
    public function delete(int|string $id): bool
    {
        //  TODO: Consider allowing $id to be null & deleting all
        return $this->make([$this->getModel()->getKeyName() => $id])
                    ->delete();
    }

    /**
     * Get Collection of class instances that match query
     *
     * @throws GuzzleException
     * @throws InvalidRelationshipException
     * @throws NoClientException
     * @throws TokenException
     */
    public function get(array|string $properties = ['*'], ?string $extra = null): Collection|Model
    {
        $properties = Arr::wrap($properties);
        $count = null;
        $page = null;
        $pageSize = null;

        // Call API to get the response
        $response = $this->getClient()
            ->setDebug($this->debug)
            ->request($this->getPath($extra));

        if (
            array_key_exists('record_count', $response) &&
            array_key_exists('page_no', $response) &&
            array_key_exists('page_size', $response)
        ) {
            $count = $response['record_count'];
            $page = $response['page_no'];
            $pageSize = $response['page_size'];
        }

        // Peel off the key if exist
        $response = $this->peelWrapperPropertyIfNeeded(Arr::wrap($response));

        // Convert to a collection of filtered objects casted to the class
        return (new Collection((array_values($response) === $response) ? $response : [$response]))
            // Cast to class with only the requested, properties
            ->map(fn ($items) => $this->getModel()
                ->newFromBuilder(
                    $properties === ['*']
                        ? (array) $items
                        : collect($items)
                            ->only($properties)
                            ->toArray()
                )
                ->setClient($this->getClient()->setDebug(false)))
            ->setPagination(count: $count, page: $page, pageSize: $pageSize);
    }

    /**
     * Get the model instance being queried.
     *
     * @throws InvalidRelationshipException
     */
    public function getModel(): Model
    {
        if (! isset($this->class)) {
            throw new InvalidRelationshipException();
        }

        if (! isset($this->model)) {
            $this->model = (new $this->class([], $this->parentModel))->setClient($this->client);
        }

        return $this->model;
    }

    /**
     * Get the path for the resource with the where filters
     *
     * @throws InvalidRelationshipException
     */
    public function getPath(?string $extra = null): ?string
    {
        $w = (array) $this->wheres;
        $id = Arr::pull($w, $this->getModel()->getKeyName());

        return $this->getModel()
            ->getPath($extra.(is_null($id) ? null : '/'.$id), $w);
    }

    /**
     * Find specific instance of class
     *
     * @throws GuzzleException
     * @throws InvalidRelationshipException
     * @throws NoClientException
     * @throws TokenException
     */
    public function find(int|string $id, array|string $properties = ['*']): Model
    {
        return $this->whereId($id)
            ->get($properties)
            ->first();
    }

    /**
     * Order newest to oldest
     */
    public function latest(?string $column = null): self
    {
        $column ??= $this->getModel()->getCreatedAtColumn();

        return $column ? $this->orderByDesc($column) : $this;
    }

    /**
     * Shortcut to where count
     *
     * @throws InvalidRelationshipException
     */
    public function limit(int|string $count): self
    {
        return $this->where('count', (int) $count);
    }

    /**
     * New up a class instance, but not saved
     *
     * @throws InvalidRelationshipException
     */
    public function make(?array $attributes = []): Model
    {
        // TODO: Make sure that the model supports "creating"
        return $this->getModel()
            ->newInstance($attributes);
    }

    /**
     * Create new Builder instance
     *
     * @throws ModelNotFoundException
     * @throws NoClientException
     */
    public function newInstance(): self
    {
        return isset($this->class)
            ? (new static())
                ->setClass($this->class)
                ->setClient($this->getClient())
                ->setParent($this->parentModel)
            : (new static())
                ->setClient($this->getClient())
                ->setParent($this->parentModel);
    }

    /**
     * Create new Builder instance for a specific model
     *
     * @throws ModelNotFoundException
     * @throws NoClientException
     */
    public function newInstanceForModel(string $model): self
    {
        return $this->newInstance()
            ->setClass($model);
    }

    /**
     * Order oldest to newest
     */
    public function oldest(?string $column = null): self
    {
        $column ??= $this->getModel()->getCreatedAtColumn();

        return $column ? $this->orderBy($column) : $this;
    }

    /**
     * Shortcut to where order & orderby with expected parameter
     *
     * The Halo API is not consistent in the parameter used to orderby
     *
     * @throws InvalidRelationshipException
     */
    public function orderBy(string $column, string $direction = 'asc'): self
    {
        return $this->where($this->getModel()->getOrderByParameter(), $column)
            ->where($this->getModel()->getOrderByDirectionParameter(), $direction !== 'asc');
    }

    /**
     * Shortcut to where order with direction set to desc
     *
     * @throws InvalidRelationshipException
     */
    public function orderByDesc(string $column): self
    {
        return $this->orderBy($column, 'desc');
    }

    /**
     * Shortcut to where page_no
     *
     * @throws InvalidRelationshipException
     */
    public function page(int|string $number, int|string|null $size = null): self
    {
        return $this->where('page_no', (int) $number)
            ->when($size, fn (self $b): self => $b->paginate($size));
    }

    /**
     * Shortcut to paginate for UK spelling
     *
     * @throws InvalidRelationshipException
     */
    public function pageinate(int|string|null $size = null): self
    {
        return $this->paginate($size);
    }

    /**
     * Shortcut to where pageinate
     *
     * @throws InvalidRelationshipException
     */
    public function paginate(int|string|null $size = null): self
    {
        return $this->unless($size, fn (self $b): self => $b->where('pageinate', false))
            ->when($size, fn (self $b): self => $b->where('pageinate', true)->where('page_size', (int) $size));
    }

    /**
     * Peel of the wrapping property if it exist.
     *
     * @throws InvalidRelationshipException
     */
    protected function peelWrapperPropertyIfNeeded(array $properties): array
    {
        // TODO: This is causing an issue where some of the models have a
        // key matching the name that is not a collection (i.e. outcome)

        // Check for single response
        if (array_key_exists(
            $this->getModel()
                ->getResponseKey(),
            $properties
        )) {
            return $properties[$this->getModel()
                ->getResponseKey()];
        }

        // Check for collection of responses
        if (array_key_exists(
            $this->getModel()
                ->getResponseCollectionKey(),
            $properties
        )) {
            return $properties[$this->getModel()
                ->getResponseCollectionKey()];
        }

        return $properties;
    }

    /**
     * Set the class to cast the response
     *
     * @throws ModelNotFoundException
     */
    public function setClass(string $class): self
    {
        if (! class_exists($class)) {
            throw new ModelNotFoundException(sprintf('The model [%s] not found.', $class));
        }

        $this->class = $class;

        return $this;
    }

    /**
     * Set the parent model
     */
    public function setParent(?Model $parent): self
    {
        $this->parentModel = $parent;

        return $this;
    }

    /**
     * Shortcut to limit
     *
     * @throws InvalidRelationshipException
     */
    public function take(int|string $count): self
    {
        return $this->limit($count);
    }

    /**
     * Add property to filter the collection
     *
     * @throws InvalidRelationshipException
     */
    public function where(iterable|string $property, $value = true): self
    {
        is_iterable($property)
            // Given multiple properties to set, so recursively call self
            ? Collection::wrap($property)->each(
                fn ($v, string $p): self => is_numeric($p)
                    // No value given, so use default value
                    ? $this->where($v, $value)
                    // Pass property & value
                    : $this->where($p, $v),
            )
            // Given single property
            : $this->wheres[$property] = is_a($value, LaravelCollection::class)
                ? $value->toArray()
                : $value;

        return $this;
    }

    /**
     * Shortcut to where property id
     *
     * @throws InvalidRelationshipException
     */
    public function whereId(int|string|null $id): self
    {
        return $this->where($this->getModel()->getKeyName(), $id);
    }

    /**
     * Shortcut to where property is false
     *
     * @throws InvalidRelationshipException
     */
    public function whereNot(string $property): self
    {
        return $this->where($property, false);
    }
}
