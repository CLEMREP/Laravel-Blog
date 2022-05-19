<?php

namespace Tests\Feature\Admin\User;

use Tests\TestCase;
use App\Models\User;
use DateTime;

class IndexUserTest extends TestCase
{
    /** @test */
    public function only_admin_can_access_index_user()
    {
        $user = User::factory()->create(['admin' => 1]);

        $this->actingAs($user)->get(route('admin.users.index'))->assertSuccessful();
    }

    /**
     * @test
     */
    public function filter_feature_works()
    {
        $users = [
            'Adrien' => User::factory()->create(['name' => 'Adrien', 'created_at' => now(),'admin' => 1]),
            'Bastien' => User::factory()->create(['name' => 'Bastien', 'created_at' => now()->addDay(1), 'admin' => 0]),
            'Clément' => User::factory()->create(['name' => 'Clément', 'created_at' => now()->addDay(2), 'admin' => 1]),
        ];

        foreach ($this->filterDataProvider() as $case => $caseData) {

            list($params, $expected) = $caseData;

            $response = $this->actingAs($users['Adrien'])->get(route('admin.users.index', $params));
            $data = $response->viewData("users");

            
            foreach ($expected as $i => $userName) {
                $this->assertEquals($userName, $data[$i]->name, $case);
            }
        }
    }

    private function filterDataProvider(): array
    {
        return [
            'order by name asc' => [
                ['order' => 'name', 'direction' => 'asc'],
                ['Adrien', 'Bastien', 'Clément'],
            ],
            'order by name desc' =>[
                ['order' => 'name', 'direction' => 'desc'],
                ['Clément', 'Bastien', 'Adrien'],
            ],
            'order by created_at asc' =>[
                ['order' => 'created_at', 'direction' => 'asc'],
                ['Adrien', 'Bastien', 'Clément'],
            ],
            'order by created_at desc' =>[
                ['order' => 'created_at', 'direction' => 'desc'],
                ['Clément', 'Bastien', 'Adrien'],
            ],
            'admin on value 1' =>[
                ['order' => 'admin', 'value' => '1'],
                ['Adrien', 'Clément'],
            ],
            'admin on value 0' =>[
                ['order' => 'admin', 'value' => '0'],
                ['Bastien'],
            ],
        ];
    }
}
