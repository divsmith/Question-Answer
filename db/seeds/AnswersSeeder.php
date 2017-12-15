<?php


use Phinx\Seed\AbstractSeed;

class AnswersSeeder extends AbstractSeed
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeders is available here:
     * http://docs.phinx.org/en/latest/seeding.html
     */
    public function run()
    {
        $data[] = [
            'uuid' => '1',
            'question_uuid' => '1',
            'text' => 'You use eloquent like this...',
            'userEmail' => 'chris@example.com',
            'upvotes' => 1
        ];
        $data[] = [
            'uuid' => '2',
            'question_uuid' => '1',
            'text' => 'You  can also use eloquent like this...',
            'userEmail' => 'ben@example.com'
        ];
        $data[] = [
            'uuid' => '3',
            'question_uuid' => '3',
            'text' => 'You use phinx like this....',
            'userEmail' => 'anne@example.com',
            'upvotes' => 1
        ];
    }
}
