<?php

use Livewire\Livewire;

it('renders successfully', function () {
    Livewire::test('gnojidba-table')
        ->assertStatus(200);
});
