<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ExperimentPhp84ArrayFunctions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'experiment:php84-arrays
                            {--dataset=all : Choose dataset to experiment with (users/numbers/all)}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Experiment with PHP 8.4 new array functions';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $dataset = $this->option('dataset');

        // Sample data arrays
        $users = [
            ['id' => 1, 'name' => 'John Doe', 'age' => 25, 'active' => true],
            ['id' => 2, 'name' => 'Jane Smith', 'age' => 30, 'active' => false],
            ['id' => 3, 'name' => 'Bob Johnson', 'age' => 35, 'active' => true],
            ['id' => 4, 'name' => 'Alice Brown', 'age' => 28, 'active' => true],
        ];

        $numbers = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10];

        if ($dataset === 'all' || $dataset === 'users') {
            $this->info('Testing with Users Dataset:');
            $this->info('------------------------');

            // array_find examples
            $this->info('1. array_find() examples:');
            $firstActiveUser = array_find($users, fn($user) => $user['active'] === true);
            $this->info("   First active user: " . json_encode($firstActiveUser));

            $userOver30 = array_find($users, fn($user) => $user['age'] > 30);
            $this->info("   First user over 30: " . json_encode($userOver30));

            // array_find_key examples
            $this->info("\n2. array_find_key() examples:");
            $firstActiveUserKey = array_find_key($users, fn($user) => $user['active'] === true);
            $this->info("   Index of first active user: $firstActiveUserKey");

            // array_any examples
            $this->info("\n3. array_any() examples:");
            $hasAdultUsers = array_any($users, fn($user) => $user['age'] >= 18);
            $this->info("   Has adult users? " . ($hasAdultUsers ? 'Yes' : 'No'));

            $hasInactiveUsers = array_any($users, fn($user) => $user['active'] === false);
            $this->info("   Has inactive users? " . ($hasInactiveUsers ? 'Yes' : 'No'));

            // array_all examples
            $this->info("\n4. array_all() examples:");
            $allUsersHaveNames = array_all($users, fn($user) => !empty($user['name']));
            $this->info("   All users have names? " . ($allUsersHaveNames ? 'Yes' : 'No'));

            $allUsersActive = array_all($users, fn($user) => $user['active'] === true);
            $this->info("   All users active? " . ($allUsersActive ? 'Yes' : 'No'));

            $this->newLine();
        }

        if ($dataset === 'all' || $dataset === 'numbers') {
            $this->info('Testing with Numbers Dataset:');
            $this->info('---------------------------');

            // array_find examples
            $this->info('1. array_find() examples:');
            $firstEvenNumber = array_find($numbers, fn($num) => $num % 2 === 0);
            $this->info("   First even number: $firstEvenNumber");

            // array_find_key examples
            $this->info("\n2. array_find_key() examples:");
            $firstNumberGreaterThanFiveKey = array_find_key($numbers, fn($num) => $num > 5);
            $this->info("   Index of first number > 5: $firstNumberGreaterThanFiveKey");

            // array_any examples
            $this->info("\n3. array_any() examples:");
            $hasNumberGreaterThanFive = array_any($numbers, fn($num) => $num > 5);
            $this->info("   Has numbers > 5? " . ($hasNumberGreaterThanFive ? 'Yes' : 'No'));

            // array_all examples
            $this->info("\n4. array_all() examples:");
            $allNumbersPositive = array_all($numbers, fn($num) => $num > 0);
            $this->info("   All numbers positive? " . ($allNumbersPositive ? 'Yes' : 'No'));

            $allNumbersEven = array_all($numbers, fn($num) => $num % 2 === 0);
            $this->info("   All numbers even? " . ($allNumbersEven ? 'Yes' : 'No'));
        }
    }
}
