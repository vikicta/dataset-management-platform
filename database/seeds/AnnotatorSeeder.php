<?php

use App\Model\Annotator;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AnnotatorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $annotator1 = new Annotator();
        $annotator1->id = 1;
        $annotator1->name = 'Annotator1';
        $annotator1->username = 'annotator1';
        $annotator1->password = 'annotator1';
        $annotator1->save();

        $annotator2 = new Annotator();
        $annotator2->id = 2;
        $annotator2->name = 'Annotator2';
        $annotator2->username = 'annotator2';
        $annotator2->password = 'annotator2';
        $annotator2->save();

    }
}
