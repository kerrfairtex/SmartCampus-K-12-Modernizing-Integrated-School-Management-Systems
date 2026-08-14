<?php

use App\User;
use App\School;
use App\Section;
use App\Department;
use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/
$factory->define(User::class, function (Faker $faker) {
    static $password;

    return [
        'name'           => $faker->name,
        'email'          => $faker->unique()->safeEmail,
        'password'       => $password ?: $password = bcrypt('secret'),
        'remember_token' => \Illuminate\Support\Str::random(10),
        'active'         => 1,
        'role'           => $faker->randomElement(['student', 'teacher', 'admin', 'accountant', 'librarian']),
        'school_id' => function () use ($faker) {
          if (School::count())
            return $faker->randomElement(School::pluck('id')->toArray());
          else return factory(School::class)->create()->id;
        },
        'code' => function () use ($faker) {
          if (School::count())
            return $faker->randomElement(School::pluck('code')->toArray());
          else return factory(School::class)->create()->code;
        },
        'student_code'   => $faker->unique()->randomNumber(7, false),
        'address'        => $faker->address,
        'about'          => $faker->sentences(3, true),
        'pic_path'       => $faker->imageUrl(640, 480),
        'phone_number'   => $faker->unique()->phoneNumber,
        'verified'       => 1,
        'section_id' => function () use ($faker) {
          if (Section::count())
            return $faker->randomElement(Section::pluck('id')->toArray());
          else return factory(Section::class)->create()->id;
        },
        'department_id' => function () use ($faker) {
          if (Department::count())
            return $faker->randomElement(Department::pluck('id')->toArray());
          else return factory(Department::class)->create()->id;
        },
        'blood_group'    => $faker->randomElement(['a+', 'b+', 'ab', 'o+']),
        'nationality'    => 'Bangladeshi',
        'gender'         => $faker->randomElement(['male', 'female']),
    ];
});

$factory->state(User::class, 'master', [
    'role' => 'master',
]);

$factory->state(User::class, 'accountant', function (Faker $faker) {
    static $i = 0; $i++;
    return [
        'role'     => 'accountant',
        'name'     => "Accountant $i",
        'email'    => "accountant{$i}@smartcampus.test",
        'password' => bcrypt("accountant123"),
    ];
});

$factory->state(User::class, 'admin', function (Faker $faker) {
    static $i = 0; $i++;
    return [
        'role'     => 'admin',
        'name'     => "Admin $i",
        'email'    => "admin{$i}@smartcampus.test",
        'password' => bcrypt("admin123"),
    ];
});

$factory->state(User::class, 'librarian', function (Faker $faker) {
    static $i = 0; $i++;
    return [
        'role'     => 'librarian',
        'name'     => "Librarian $i",
        'email'    => "librarian{$i}@smartcampus.test",
        'password' => bcrypt("librarian123"),
    ];
});

$factory->state(User::class, 'teacher', function (Faker $faker) {
    static $i = 0; $i++;
    return [
        'role'     => 'teacher',
        'name'     => "Teacher $i",
        'email'    => "teacher{$i}@smartcampus.test",
        'password' => bcrypt("teacher123"),
    ];
});

$factory->state(User::class, 'student', function (Faker $faker) {
    static $i = 0; $i++;
    return [
        'role'     => 'student',
        'name'     => "Student $i",
        'email'    => "student{$i}@smartcampus.test",
        'password' => bcrypt("student123"),
    ];
});
