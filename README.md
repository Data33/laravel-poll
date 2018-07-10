Data33/Laravel-Poll
=======

A package for managing polls in Laravel.

## Installation ##

Open your `composer.json` file and add the following to the `require` key:

	"data33/laravel-poll": "1.0.*"

---
	
After adding the key, run composer update from the command line to install the package 

```bash
composer update
```
	
## Configuration ##
Before you can start using the package we need to set some configurations.
To do so you must first publish the config file, you can do this with the following `artisan` command. 

```bash
php artisan vendor:publish --provider="Data33\LaravelPoll\PollServiceProvider"
```
After running the above command, you should see the following changes:
* A config file should be available at `config/polls.php`
* A few new migrations should be placed in your `database/migrations` folder
* A few new views should be placed in the folder `resources/views/vendor/data33/laravel-poll`
* 
If you wish to extend this package, you can specify your own classes to be used as models in the ` config/polls.php` file. Make sure your models extend the existing ones.

## Usage ##

### Creating a new poll ###
You can either create polls manually by using the models directly, or you can use the createPoll helper method.
```php
use Data33\LaravelPoll\Models\Poll;

$title = 'A new poll';
$text = 'A longer text describing the poll';
$type = Poll::TYPE_SINGLE;
// $type = Poll::TYPE_MULTIPLE;
$options = [
    'The first option',
    'The second option',
    'The third option',
];
$endDate = new Carbon\Carbon('2018-12-24 00:00:00');

$poll = Poll::createPoll($title, $text, $type, $options, $endDate);
```

### Adding more options ###
If you need to add more options to a poll after it has already been created you may use the addOption method.
```php
    $poll->addOption('A fourth option')
        ->addOption('A fifth option');
```

### Voting for an option ###
Let's assume your App\User model uses the Voter trait.
```php
    auth()->user()
        ->voteFor($poll, $pollOption);
```

### Checking voting status for a voter ###
```php
    if (auth()->user()->hasVotedInPoll($poll)) {
        echo 'User voted in poll';
    }
    
    if (auth()->user()->hasVotedForOption($poll, $option)) {
        echo 'User voted for specific option';
    }
```
