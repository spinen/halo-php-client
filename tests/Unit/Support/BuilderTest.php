<?php

namespace Tests\Unit\Support;

use BadMethodCallException;
use Illuminate\Support\Str;
use Mockery;
use Mockery\Mock;
use Spinen\Halo\Action;
use Spinen\Halo\Agent;
use Spinen\Halo\Api\Client;
use Spinen\Halo\Exceptions\InvalidRelationshipException;
use Spinen\Halo\Exceptions\ModelNotFoundException;
use Spinen\Halo\Quote;
use Spinen\Halo\Report;
use Spinen\Halo\Supplier;
use Spinen\Halo\Support\Builder;
use Spinen\Halo\Support\Collection;
use Spinen\Halo\Support\Model;
use Spinen\Halo\Team;
use Spinen\Halo\Ticket;
use Spinen\Halo\User;
use Spinen\Halo\Webhook;
use Tests\TestCase;

/**
 * Class BuilderTest
 */
class BuilderTest extends TestCase
{
    /**
     * @var Builder
     */
    protected $builder;

    /**
     * @var Mock
     */
    protected $client_mock;

    /**
     * @var array
     */
    protected $team_response = [
        [
            'color' => '#000000',
            'id' => 1,
            'name' => 'Team 1',
        ],
        [
            'color' => '#ffffff',
            'id' => 2,
            'name' => 'Team 2',
        ],
    ];

    protected function setUp(): void
    {
        $this->client_mock = Mockery::mock(Client::class);

        $this->builder = new Builder();
        $this->builder->setClient($this->client_mock);
    }

    /**
     * @test
     */
    public function it_can_be_constructed()
    {
        $this->assertInstanceOf(Builder::class, $this->builder);
    }

    /**
     * @test
     *
     * @dataProvider rootModels
     */
    public function it_returns_builder_for_root_models($model)
    {
        $this->assertInstanceOf(Builder::class, $this->builder->{$model}(), 'Builder');

        $this->client_mock->shouldReceive('setDebug')
            ->once()
            ->with(false)
            ->andReturnSelf();

        $this->client_mock->shouldReceive('request')
            ->withAnyArgs()
            ->andReturn([]);

        $this->assertInstanceOf(Collection::class, $this->builder->{$model}, 'Collection');
    }

    public static function rootModels()
    {
        return [
            'actions' => ['model' => 'actions'],
            'agents' => ['model' => 'agents'],
            'appointments' => ['model' => 'appointments'],
            'articles' => ['model' => 'articles'],
            'assets' => ['model' => 'assets'],
            'attachments' => ['model' => 'attachments'],
            'clients' => ['model' => 'clients'],
            'contracts' => ['model' => 'contracts'],
            'invoices' => ['model' => 'invoices'],
            'items' => ['model' => 'items'],
            'opportunities' => ['model' => 'opportunities'],
            'projects' => ['model' => 'projects'],
            'quotes' => ['model' => 'quotes'],
            'reports' => ['model' => 'reports'],
            'sites' => ['model' => 'sites'],
            'statuses' => ['model' => 'statuses'],
            'suppliers' => ['model' => 'suppliers'],
            'teams' => ['model' => 'teams'],
            'tickets' => ['model' => 'tickets'],
            'ticket_types' => ['model' => 'ticket_types'],
            'users' => ['model' => 'users'],
            'webhooks' => ['model' => 'webhooks'],
            'webhook_events' => ['model' => 'webhook_events'],
        ];
    }

    /**
     * @test
     */
    public function it_returns_an_agent_for_current_token()
    {
        $this->client_mock->shouldReceive('setDebug')
            ->with(false)
            ->andReturnSelf();

        $this->client_mock->shouldReceive('request')
            ->once()
            ->withAnyArgs() // TODO: Should we assert path?
            ->andReturn([['name' => 'Agent']]);

        $this->assertInstanceOf(Agent::class, $this->builder->agent);
    }

    /**
     * @test
     */
    public function it_returns_a_user_for_current_token()
    {
        $this->client_mock->shouldReceive('setDebug')
            ->with(false)
            ->andReturnSelf();

        $this->client_mock->shouldReceive('request')
            ->once()
            ->withAnyArgs()
            ->andReturn([['name' => 'User']]);

        $this->assertInstanceOf(User::class, $this->builder->user);
    }

    /**
     * @test
     */
    public function it_raises_exception_to_unknown_method()
    {
        $this->expectException(BadMethodCallException::class);

        $this->builder->something();
    }

    /**
     * @test
     */
    public function it_returns_null_for_unknown_property()
    {
        $this->assertNull($this->builder->something);
    }

    /**
     * @test
     */
    public function it_will_create_a_model_and_save_via_api_call()
    {
        $this->client_mock->shouldReceive('post')
            ->withArgs(
                [
                    Mockery::any(),
                    ['some' => 'property'],
                ]
            )
            ->once()
            ->andReturn([]);

        $this->builder->setClass(Action::class);

        $this->assertInstanceOf(Model::class, $this->builder->create(['some' => 'property']));
    }

    /**
     * @test
     */
    public function it_raises_exception_when_trying_to_create_unknown_model()
    {
        $this->expectException(InvalidRelationshipException::class);

        $this->assertInstanceOf(Model::class, $this->builder->create(['some' => 'property']));
    }

    /**
     * @test
     */
    public function it_get_only_specified_properties()
    {
        $this->client_mock->shouldReceive('request')
            ->once()
            ->withAnyArgs()
            ->andReturn($this->team_response);

        $this->client_mock->shouldReceive('setDebug')
            ->with(false)
            ->andReturnSelf();

        $results = $this->builder->setClass(Team::class)
            ->get(['color']);

        $this->assertInstanceOf(Collection::class, $results, 'Collection');

        $this->assertCount(2, $results, '2 Teams');

        $this->assertInstanceOf(Team::class, $results[0], 'Result 1');
        $this->assertInstanceOf(Team::class, $results[1], 'Result 2');

        $this->arrayHasKey('color', $results[0]->toArray(), 'color property');
        $this->assertArrayNotHasKey('id', $results[0]->toArray(), 'id property missing');
        $this->assertArrayNotHasKey('name', $results[0]->toArray(), 'name property missing');
    }

    /**
     * @test
     */
    public function it_will_make_a_model_without_saving_via_api_call()
    {
        $this->client_mock->shouldNotHaveBeenCalled();

        $this->builder->setClass(Webhook::class);

        $this->assertInstanceOf(Model::class, $this->builder->make(['some' => 'property']));
    }

    /**
     * @test
     */
    public function it_sets_expected_properties_when_making_a_new_instance()
    {
        $parent_mock = Mockery::mock(Model::class);

        $this->builder->setClass(Quote::class)
            ->setParent($parent_mock);

        $new = $this->builder->newInstance();

        $this->assertInstanceOf(Quote::class, $new->getModel(), 'class');

        $this->assertEquals($this->client_mock, $new->getClient(), 'client');
    }

    /**
     * @test
     */
    public function it_allows_setting_model_for_new_instance()
    {
        $this->builder->setClass(Team::class);

        $new = $this->builder->newInstanceForModel(Ticket::class);

        $this->assertInstanceOf(Ticket::class, $new->getModel());
    }

    /**
     * @test
     */
    public function it_peels_off_single_response_keys()
    {
        $this->client_mock->shouldReceive('request')
            ->once()
            ->withAnyArgs()
            ->andReturn(
                [
                    'team' => [
                        'id' => 1,
                    ],
                ]
            );

        $this->client_mock->shouldReceive('setDebug')
            ->with(false)
            ->andReturnSelf();

        $results = $this->builder->setClass(Team::class)
            ->get();

        $this->assertArrayHasKey('id', $results[0]->toArray(), 'id');
        $this->assertArrayNotHasKey('team', $results[0]->toArray(), 'team');
    }

    /**
     * @test
     */
    public function it_peels_off_collection_response_keys()
    {
        $this->client_mock->shouldReceive('request')
            ->once()
            ->withAnyArgs()
            ->andReturn(
                [
                    'teams' => [
                        [
                            'id' => 1,
                        ],
                        [
                            'id' => 2,
                        ],
                    ],
                ]
            );

        $this->client_mock->shouldReceive('setDebug')
            ->with(false)
            ->andReturnSelf();

        $results = $this->builder->setClass(Team::class)
            ->get();

        $this->assertCount(2, $results, 'both teams');

        $this->assertArrayHasKey('id', $results[0]->toArray(), 'id');
        $this->assertArrayNotHasKey('team', $results[0]->toArray(), 'teams');
    }

    /**
     * @test
     */
    public function it_allows_setting_class()
    {
        $this->builder->setClass(Supplier::class);

        $this->assertInstanceOf(Supplier::class, $this->builder->getModel());
    }

    /**
     * @test
     */
    public function it_raises_exception_to_setting_unknown_class()
    {
        $this->expectException(ModelNotFoundException::class);

        $this->builder->setClass('Some\\Unknown\\Class');
    }

    /**
     * @test
     *
     * @dataProvider filterProvider
     */
    public function it_where_filters_to_request_as_query_string_parameters($class, $calls, $uri)
    {
        $this->builder->setClass($class);

        Collection::wrap($calls)->each(fn ($call) => match (true) {
            is_null($call['property']) && is_null($call['value']) => $this->builder->{$call['method']}(),
            is_null($call['property']) => $this->builder->{$call['method']}($call['value']),
            is_null($call['value']) => $this->builder->{$call['method']}($call['property']),
            default => $this->builder->{$call['method']}($call['property'], $call['value']),
        });

        $this->assertEquals($uri, $this->builder->getPath());
    }

    public static function filterProvider()
    {
        return [
            'simple' => [
                'class' => Report::class,
                'calls' => [
                    [
                        'method' => 'where',
                        'property' => $property = Str::random(),
                        'value' => $value = Str::random(),
                    ],
                ],
                'uri' => '/report?'.$property.'='.$value,
            ],
            'multiple' => [
                'class' => Report::class,
                'calls' => [
                    [
                        'method' => 'where',
                        'property' => $property1 = Str::random(),
                        'value' => $value1 = Str::random(),
                    ],
                    [
                        'method' => 'where',
                        'property' => $property2 = Str::random(),
                        'value' => $value2 = Str::random(),
                    ],
                ],
                'uri' => '/report?'.$property1.'='.$value1.'&'.$property2.'='.$value2,
            ],
            'array' => [
                'class' => Report::class,
                'calls' => [
                    [
                        'method' => 'where',
                        'property' => $property = Str::random(),
                        'value' => $value = collect([$one = Str::random(), $two = Str::random()]),
                    ],
                ],
                'uri' => '/report?'.$property.'%5B0%5D='.$one.'&'.$property.'%5B1%5D='.$two,
            ],
            'null value' => [
                'class' => Report::class,
                'calls' => [
                    [
                        'method' => 'where',
                        'property' => $property = Str::random(),
                        'value' => null,
                    ],
                ],
                'uri' => '/report?'.$property.'=true',
            ],
            'whereNot' => [
                'class' => Report::class,
                'calls' => [
                    [
                        'method' => 'whereNot',
                        'property' => $property = Str::random(),
                        'value' => null,
                    ],
                ],
                'uri' => '/report?'.$property.'=false',
            ],
            'whereId' => [
                'class' => Report::class,
                'calls' => [
                    [
                        'method' => 'whereId',
                        'property' => null,
                        'value' => $value = random_int(20, 100),
                    ],
                ],
                'uri' => '/report/'.$value,
            ],
            'limit' => [
                'class' => Report::class,
                'calls' => [
                    [
                        'method' => 'limit',
                        'property' => null,
                        'value' => $value = random_int(20, 100),
                    ],
                ],
                'uri' => '/report?count='.$value,
            ],
            'take' => [
                'class' => Report::class,
                'calls' => [
                    [
                        'method' => 'take',
                        'property' => null,
                        'value' => $value = random_int(20, 100),
                    ],
                ],
                'uri' => '/report?count='.$value,
            ],
            'latest' => [
                'class' => Ticket::class,
                'calls' => [
                    [
                        'method' => 'latest',
                        'property' => null,
                        'value' => null,
                    ],
                ],
                'uri' => '/tickets?order=dateoccurred&orderdesc=true',
            ],
            'latest without created' => [
                'class' => Report::class,
                'calls' => [
                    [
                        'method' => 'latest',
                        'property' => null,
                        'value' => null,
                    ],
                ],
                'uri' => '/report',
            ],
            'oldest' => [
                'class' => Ticket::class,
                'calls' => [
                    [
                        'method' => 'oldest',
                        'property' => null,
                        'value' => null,
                    ],
                ],
                'uri' => '/tickets?order=dateoccurred&orderdesc=false',
            ],
            'oldest without created' => [
                'class' => Report::class,
                'calls' => [
                    [
                        'method' => 'oldest',
                        'property' => null,
                        'value' => null,
                    ],
                ],
                'uri' => '/report',
            ],
            'page' => [
                'class' => Report::class,
                'calls' => [
                    [
                        'method' => 'page',
                        'property' => $property = random_int(20, 100),
                        'value' => null,
                    ],
                ],
                'uri' => '/report?page_no='.$property,
            ],
            'page with pagination' => [
                'class' => Report::class,
                'calls' => [
                    [
                        'method' => 'page',
                        'property' => $property = random_int(20, 100),
                        'value' => $value = random_int(20, 100),
                    ],
                ],
                'uri' => '/report?page_no='.$property.'&pageinate=true&page_size='.$value,
            ],
            'paginate' => [
                'class' => Report::class,
                'calls' => [
                    [
                        'method' => 'paginate',
                        'property' => null,
                        'value' => null,
                    ],
                ],
                'uri' => '/report?pageinate=true',
            ],
            'paginate with size' => [
                'class' => Report::class,
                'calls' => [
                    [
                        'method' => 'paginate',
                        'property' => $property = random_int(20, 100),
                        'value' => null,
                    ],
                ],
                'uri' => '/report?pageinate=true&page_size='.$property,
            ],
            'pageinate' => [
                'class' => Report::class,
                'calls' => [
                    [
                        'method' => 'pageinate',
                        'property' => null,
                        'value' => null,
                    ],
                ],
                'uri' => '/report?pageinate=true',
            ],
            'pageinate with size' => [
                'class' => Report::class,
                'calls' => [
                    [
                        'method' => 'pageinate',
                        'property' => $property = random_int(20, 100),
                        'value' => null,
                    ],
                ],
                'uri' => '/report?pageinate=true&page_size='.$property,
            ],
        ];
    }
}
