<?php


use Phinx\Seed\AbstractSeed;

class QuestionsSeeder extends AbstractSeed
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
            'uuid'       => '1',
            'title'      => 'Question About Eloquent',
            'text'       => 'I have a question about how to use eloquent...',
            'user_email' => 'anne@example.com',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ];
        $data[] = [
            'uuid'       => '2',
            'title'      => 'Another Question About Eloquent',
            'text'       => 'I have another question about how to use eloquent...',
            'user_email' => 'anne@example.com',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ];
        $data[] = [
            'uuid'       => '3',
            'title'      => 'Question About Phinx',
            'text'       => 'I have a question about how to use phinx...',
            'user_email' => 'ben@example.com',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ];

        $users = $this->table('questions');
        $users->insert($data)->save();
    }
}
