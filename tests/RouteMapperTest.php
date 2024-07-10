<?php

namespace Uesley\Test\Unit;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Uesley\RouterSummary\RouteMapper;

class RouteMapperTest extends TestCase
{
    #[DataProvider('routeNamesAndMethodsProvider')]
    public function testCanMapRouteNameToMethod(string $route_name, string $expected_method): void
    {
        $this->assertEquals(
            $expected_method,
            RouteMapper::deduceMethod($route_name)
        );
    }

    public static function routeNamesAndMethodsProvider(): array
    {
        return [
            ['products.store', 'storeProduct'],
            ['products.update', 'updateProduct'],
            ['products.index', 'listProducts'],
            ['products.show', 'getProduct'],
            ['products.destroy', 'deleteProduct'],

            ['products.sub-products.store', 'storeProductSubProduct'],
            ['products.sub-products.update', 'updateProductSubProduct'],
            ['products.sub-products.show', 'getProductSubProduct'],
            ['products.sub-products.index', 'listProductSubProducts'],
            ['products.sub-products.destroy', 'deleteProductSubProduct'],

            ['authors.books.comments.store', 'storeAuthorBookComment'],
            ['authors.books.comments.update', 'updateAuthorBookComment'],
            ['authors.books.comments.index', 'listAuthorBookComments'],
            ['authors.books.comments.show', 'getAuthorBookComment'],
            ['authors.books.comments.destroy', 'deleteAuthorBookComment'],

            ['methodNotCompatibleWithNothing', 'methodNotCompatibleWithNothing'],
            ['not.compatible.with.dots', 'notCompatibleWithDots'],
        ];
    }
}
