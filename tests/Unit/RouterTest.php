<?php
namespace Tests\Unit;
use src\app\Router;
use \PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\Test;
use \src\app\Exceptions\RouteNotFoundException;
use PHPUnit\Framework\Attributes\DataProvider;
use tests\Unit\RouterDataProvider;

class RouterTest extends TestCase
{
          private Router $router;
          protected function setUp(): void
          {
                    parent::setUp();
                    $this->router = new Router();
          }
          // #[Test]
          // public function is_register_route()
          // {
          //           // register route
          //           $this->router->register("get", "/test", ["Users", "index"]);
          //           // Expected 
          //           $expected = [
          //                     "get" => [
          //                               "/test" => ["Users", "index"]
          //                     ]
          //           ];

          //           $this->assertEquals($expected, $this->router->getRoutesAll());
          // }
          // // Test to confirm is get Method of Router class works as Expected.

          // #[Test]
          // public function is_register_get_router()
          // {
          //           $this->router->get("/test", ["Users", "index"]);
          //           $expected = [
          //                     "get" => [
          //                               "/test" => ["Users", "index"]
          //                     ]
          //           ];

          //           $this->assertEquals($expected, $this->router->getRoutesAll());
          // }
          // #[Test]
          // public function is_register_post_router()
          // {
          //           $this->router->post("/test", ["Users", "index"]);
          //           $expected = [
          //                     "post" => [
          //                               "/test" => ["Users", "index"]
          //                     ]
          //           ];

          //           $this->assertEquals($expected, $this->router->getRoutesAll());
          // }

          // // Test to check No route is register 
          // // when Object is initiated.
          // #[TEST]
          // public function no_route_when_initiated()
          // {
          //           $this->assertEmpty($this->router->getRoutesAll());
          // }
          // public static function routeNotFoundCasesProvider(): array
          // {
          //           return RouterDataProvider::RouteNotFoundCases();
          // }
          // #[Test]
          // #[DataProvider("routeNotFoundCasesProvider")]
          // public function it_throws_route_not_found_exception(string $requst_uri, string $requst_method)
          // {

          //           $users = new class () {
          //                     public function delete(): bool
          //                     {
          //                               return true;
          //                     }
          //           };
          //           $this->router->post("/user", [$users::class, "store"]);
          //           $this->router->get("/user", ["Users", "index"]);

          //           $this->expectException(RouteNotFoundException::class);
          //           $this->router->getRoute($requst_uri, $requst_method);
          // }
          #[TEST]
          public function it_resolve_route_from_a_closure()
          {

                    $this->router->get("/user", function () {
                              return "1";
                    });
                    $expected = "1";

                    $this->assertEquals($expected, $this->router->getRoute("/user", "get"));

          }
          #[TEST]
          public function it_resolve_route_from_an_array()
          {
                    $users = new class () {
                              public function store(): bool
                              {
                                        return true;
                              }
                    };

                    $this->router->get("/user", [$users::class, "store"]);
                    $expected = true;

                    $this->assertEquals($expected, $this->router->getRoute("/user", "get"));

          }
}