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
            'user_email' => 'chris@example.com',
            'upvotes' => 1,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ];
        $data[] = [
            'uuid' => '2',
            'question_uuid' => '1',
            'text' => 'You  can also use eloquent like this...',
            'user_email' => 'ben@example.com',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ];
        $data[] = [
            'uuid' => '3',
            'question_uuid' => '3',
            'text' => 'You use phinx like this....',
            'user_email' => 'anne@example.com',
            'upvotes' => 1,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ];

        $answers = $this->table('answers');
        $answers->insert($data)->save();
    }
}
