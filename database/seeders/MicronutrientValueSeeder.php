<?php

namespace Database\Seeders;

use App\Models\MicronutrientValue;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MicronutrientValueSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        MicronutrientValue::truncate();

        DB::table('micronutrient_values')->insert([
            ['micronutrient_id' => '1', 'value' => '1.000', 'red' => '0', 'green' => '153', 'blue' => '102'],
            ['micronutrient_id' => '1', 'value' => '1.005', 'red' => '77', 'green' => '153', 'blue' => '77'],
            ['micronutrient_id' => '1', 'value' => '1.010', 'red' => '102', 'green' => '166', 'blue' => '51'],
            ['micronutrient_id' => '1', 'value' => '1.015', 'red' => '153', 'green' => '179', 'blue' => '51'],
            ['micronutrient_id' => '1', 'value' => '1.020', 'red' => '179', 'green' => '191', 'blue' => '51'],
            ['micronutrient_id' => '1', 'value' => '1.025', 'red' => '204', 'green' => '191', 'blue' => '38'],
            ['micronutrient_id' => '1', 'value' => '1.030', 'red' => '203', 'green' => '204', 'blue' => '26'],

            ['micronutrient_id' => '2', 'value' => '5.0', 'red' => '255', 'green' => '161', 'blue' => '26'],
            ['micronutrient_id' => '2', 'value' => '6.0', 'red' => '255', 'green' => '179', 'blue' => '77'],
            ['micronutrient_id' => '2', 'value' => '6.5', 'red' => '250', 'green' => '204', 'blue' => '77'],
            ['micronutrient_id' => '2', 'value' => '7.0', 'red' => '219', 'green' => '204', 'blue' => '0'],
            ['micronutrient_id' => '2', 'value' => '7.5', 'red' => '179', 'green' => '204', 'blue' => '0'],
            ['micronutrient_id' => '2', 'value' => '8.0', 'red' => '153', 'green' => '204', 'blue' => '0'],
            ['micronutrient_id' => '2', 'value' => '8.5', 'red' => '51', 'green' => '153', 'blue' => '89'],

            ['micronutrient_id' => '3', 'value' => '-1', 'red' => '230', 'green' => '255', 'blue' => '128'],
            ['micronutrient_id' => '3', 'value' => '0', 'red' => '204', 'green' => '255', 'blue' => '128'],
            ['micronutrient_id' => '3', 'value' => '0.3', 'red' => '179', 'green' => '242', 'blue' => '128'],
            ['micronutrient_id' => '3', 'value' => '1.0', 'red' => '140', 'green' => '242', 'blue' => '153'],
            ['micronutrient_id' => '3', 'value' => '3.0', 'red' => '128', 'green' => '242', 'blue' => '179'],
            ['micronutrient_id' => '3', 'value' => '20', 'red' => '102', 'green' => '230', 'blue' => '179'],

            ['micronutrient_id' => '4', 'value' => '0', 'red' => '255', 'green' => '204', 'blue' => '153'],
            ['micronutrient_id' => '4', 'value' => '0.5', 'red' => '255', 'green' => '153', 'blue' => '153'],
            ['micronutrient_id' => '4', 'value' => '1.5', 'red' => '255', 'green' => '102', 'blue' => '179'],
            ['micronutrient_id' => '4', 'value' => '4.0', 'red' => '204', 'green' => '51', 'blue' => '153'],
            ['micronutrient_id' => '4', 'value' => '8.0', 'red' => '138', 'green' => '23', 'blue' => '138'],
            ['micronutrient_id' => '4', 'value' => '16', 'red' => '92', 'green' => '0', 'blue' => '151'],

            ['micronutrient_id' => '5', 'value' => '0', 'red' => '191', 'green' => '51', 'blue' => '0'],
            ['micronutrient_id' => '5', 'value' => '100', 'red' => '204', 'green' => '102', 'blue' => '153'],
            ['micronutrient_id' => '5', 'value' => '200', 'red' => '230', 'green' => '128', 'blue' => '153'],
            ['micronutrient_id' => '5', 'value' => '300', 'red' => '230', 'green' => '166', 'blue' => '179'],
            ['micronutrient_id' => '5', 'value' => '400', 'red' => '242', 'green' => '204', 'blue' => '204'],
            ['micronutrient_id' => '5', 'value' => '500', 'red' => '242', 'green' => '230', 'blue' => '230'],

            ['micronutrient_id' => '6', 'value' => '-1', 'red' => '255', 'green' => '250', 'blue' => '230'],
            ['micronutrient_id' => '6', 'value' => '1000', 'red' => '255', 'green' => '242', 'blue' => '230'],
            ['micronutrient_id' => '6', 'value' => '2000', 'red' => '255', 'green' => '230', 'blue' => '230'],
            ['micronutrient_id' => '6', 'value' => '2000', 'red' => '255', 'green' => '217', 'blue' => '230'],
            ['micronutrient_id' => '6', 'value' => '3000', 'red' => '255', 'green' => '204', 'blue' => '230'],
            ['micronutrient_id' => '6', 'value' => '3000', 'red' => '255', 'green' => '191', 'blue' => '230'],

            ['micronutrient_id' => '7', 'value' => '0', 'red' => '46', 'green' => '115', 'blue' => '126'],
            ['micronutrient_id' => '7', 'value' => '0.6', 'red' => '26', 'green' => '209', 'blue' => '82'],
            ['micronutrient_id' => '7', 'value' => '1.4', 'red' => '107', 'green' => '255', 'blue' => '28'],
            ['micronutrient_id' => '7', 'value' => '2.8', 'red' => '194', 'green' => '230', 'blue' => '12'],
            ['micronutrient_id' => '7', 'value' => '5.0', 'red' => '247', 'green' => '255', 'blue' => '89'],

            ['micronutrient_id' => '8', 'value' => '0', 'red' => '255', 'green' => '242', 'blue' => '191'],
            ['micronutrient_id' => '8', 'value' => '0', 'red' => '230', 'green' => '207', 'blue' => '161'],
            ['micronutrient_id' => '8', 'value' => '5', 'red' => '218', 'green' => '190', 'blue' => '161'],
            ['micronutrient_id' => '8', 'value' => '12', 'red' => '202', 'green' => '184', 'blue' => '161'],
            ['micronutrient_id' => '8', 'value' => '30', 'red' => '161', 'green' => '138', 'blue' => '161'],

            ['micronutrient_id' => '9', 'value' => '1.0', 'red' => '255', 'green' => '242', 'blue' => '194'],
            ['micronutrient_id' => '9', 'value' => '2.5', 'red' => '247', 'green' => '230', 'blue' => '242'],
            ['micronutrient_id' => '9', 'value' => '5.0', 'red' => '242', 'green' => '204', 'blue' => '242'],
            ['micronutrient_id' => '9', 'value' => '7.5', 'red' => '239', 'green' => '179', 'blue' => '242'],
            ['micronutrient_id' => '9', 'value' => '10', 'red' => '191', 'green' => '153', 'blue' => '242'],

            ['micronutrient_id' => '10', 'value' => '10', 'red' => '255', 'green' => '242', 'blue' => '194'],
            ['micronutrient_id' => '10', 'value' => '15', 'red' => '247', 'green' => '230', 'blue' => '242'],
            ['micronutrient_id' => '10', 'value' => '20', 'red' => '242', 'green' => '204', 'blue' => '242'],
            ['micronutrient_id' => '10', 'value' => '25', 'red' => '239', 'green' => '179', 'blue' => '242'],
            ['micronutrient_id' => '10', 'value' => '40', 'red' => '191', 'green' => '153', 'blue' => '242'],

            ['micronutrient_id' => '11', 'value' => '-1', 'red' => '153', 'green' => '255', 'blue' => '191'],
            ['micronutrient_id' => '11', 'value' => '5', 'red' => '153', 'green' => '255', 'blue' => '128'],
            ['micronutrient_id' => '11', 'value' => '15', 'red' => '131', 'green' => '194', 'blue' => '29'],
            ['micronutrient_id' => '11', 'value' => '30', 'red' => '156', 'green' => '152', 'blue' => '0'],
            ['micronutrient_id' => '11', 'value' => '60', 'red' => '138', 'green' => '92', 'blue' => '23'],
            ['micronutrient_id' => '11', 'value' => '110', 'red' => '108', 'green' => '54', 'blue' => '0'],

            ['micronutrient_id' => '12', 'value' => '0', 'red' => '255', 'green' => '166', 'blue' => '247'],
            ['micronutrient_id' => '12', 'value' => '0.5', 'red' => '242', 'green' => '166', 'blue' => '247'],
            ['micronutrient_id' => '12', 'value' => '1', 'red' => '230', 'green' => '166', 'blue' => '247'],
            ['micronutrient_id' => '12', 'value' => '2', 'red' => '217', 'green' => '191', 'blue' => '247'],
            ['micronutrient_id' => '12', 'value' => '5', 'red' => '191', 'green' => '204', 'blue' => '247'],
            ['micronutrient_id' => '12', 'value' => '10', 'red' => '179', 'green' => '204', 'blue' => '247'],
            ['micronutrient_id' => '12', 'value' => '25', 'red' => '153', 'green' => '230', 'blue' => '247'],
        ]);
    }
}
