<?php

test('it can resolve something out of the container', function () {
    //arrange
    $container = new \core\Container();

    $container->bind('foo', fn() => 'bar');
    //act
    $result = $container->resolve('foo');

    //assert/expect
    expect($result)->toEqual('bar');
});
