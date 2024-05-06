<?php

// @formatter:off
// phpcs:ignoreFile
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * 
 *
 * @property string $id
 * @property string $name
 * @property string $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Connector> $connectors
 * @property-read int|null $connectors_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Event> $events
 * @property-read int|null $events_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Tag> $tags
 * @property-read int|null $tags_count
 * @property-read \App\Models\User $user
 * @method static \Database\Factories\CalendarFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Calendar newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Calendar newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Calendar onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Calendar query()
 * @method static \Illuminate\Database\Eloquent\Builder|Calendar whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Calendar whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Calendar whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Calendar whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Calendar whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Calendar whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Calendar withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Calendar withoutTrashed()
 */
	class Calendar extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property string $id
 * @property string $name
 * @property string $color
 * @property string|null $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Calendar> $calendars
 * @property-read int|null $calendars_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Event> $events
 * @property-read int|null $events_count
 * @property-read mixed $primary_tag
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Scraper> $scrapers
 * @property-read int|null $scrapers_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Tag> $tags
 * @property-read int|null $tags_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\User> $users
 * @property-read int|null $users_count
 * @method static \Database\Factories\ConnectorFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Connector newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Connector newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Connector onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Connector query()
 * @method static \Illuminate\Database\Eloquent\Builder|Connector whereColor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Connector whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Connector whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Connector whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Connector whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Connector whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Connector whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Connector withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Connector withoutTrashed()
 */
	class Connector extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Connectorable newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Connectorable newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Connectorable query()
 */
	class Connectorable extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property string $id
 * @property string $name
 * @property string|null $description
 * @property \Illuminate\Support\Carbon $start_at
 * @property \Illuminate\Support\Carbon $end_at
 * @property bool $is_all_day
 * @property string $eventable_type
 * @property string $eventable_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $eventable
 * @method static \Illuminate\Database\Eloquent\Builder|Event allDay(bool $isAllDay = true)
 * @method static \Database\Factories\EventFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Event newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Event newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Event onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Event query()
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereEndAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereEventableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereEventableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereIsAllDay($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereStartAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Event withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Event withoutTrashed()
 */
	class Event extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property string $id
 * @property string $run_id
 * @property array $data
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Result> $results
 * @property-read int|null $results_count
 * @property-read \App\Models\Run $run
 * @method static \Database\Factories\ExtractionFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Extraction newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Extraction newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Extraction onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Extraction query()
 * @method static \Illuminate\Database\Eloquent\Builder|Extraction whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Extraction whereData($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Extraction whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Extraction whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Extraction whereRunId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Extraction whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Extraction withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Extraction withoutTrashed()
 */
	class Extraction extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property string $id
 * @property string $source_id
 * @property string $title
 * @property string|null $description
 * @property string $url
 * @property string|null $image
 * @property \Illuminate\Support\Carbon $active_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read string $active_ago
 * @property-read \App\Models\Source $source
 * @method static \Illuminate\Database\Eloquent\Builder|News newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|News newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|News onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|News query()
 * @method static \Illuminate\Database\Eloquent\Builder|News whereActiveAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|News whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|News whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|News whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|News whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|News whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|News whereSourceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|News whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|News whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|News whereUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|News withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|News withoutTrashed()
 */
	class News extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property string $id
 * @property string $extraction_id
 * @property bool $is_valid
 * @property array $data
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\Extraction $extraction
 * @method static \Illuminate\Database\Eloquent\Builder|Result newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Result newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Result onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Result query()
 * @method static \Illuminate\Database\Eloquent\Builder|Result valid(bool $valid = true)
 * @method static \Illuminate\Database\Eloquent\Builder|Result whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Result whereData($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Result whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Result whereExtractionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Result whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Result whereIsValid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Result whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Result withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Result withoutTrashed()
 */
	class Result extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property string $id
 * @property string $scraper_id
 * @property \App\Enums\Run\Status $status
 * @property array|null $request
 * @property array|null $response
 * @property \Illuminate\Support\Carbon|null $started_at
 * @property \Illuminate\Support\Carbon|null $ended_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\Extraction|null $extraction
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Result> $results
 * @property-read int|null $results_count
 * @property-read \App\Models\Scraper $scraper
 * @method static \Database\Factories\RunFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Run newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Run newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Run onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Run query()
 * @method static \Illuminate\Database\Eloquent\Builder|Run whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Run whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Run whereEndedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Run whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Run whereRequest($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Run whereResponse($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Run whereScraperId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Run whereStartedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Run whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Run whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Run withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Run withoutTrashed()
 */
	class Run extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property string $id
 * @property string $name
 * @property string $connector_id
 * @property string|null $description
 * @property \App\Enums\Scraper\Method $method
 * @property \App\Enums\Scraper\Type $type
 * @property string $url
 * @property array|null $headers
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\Connector $connector
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Extraction> $extractions
 * @property-read int|null $extractions_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Run> $runs
 * @property-read int|null $runs_count
 * @method static \Database\Factories\ScraperFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Scraper method(\App\Enums\Scraper\Method $method = \App\Enums\Scraper\Method::GET)
 * @method static \Illuminate\Database\Eloquent\Builder|Scraper newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Scraper newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Scraper onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Scraper query()
 * @method static \Illuminate\Database\Eloquent\Builder|Scraper type(\App\Enums\Scraper\Type $type = \App\Enums\Scraper\Type::WEBHOOK)
 * @method static \Illuminate\Database\Eloquent\Builder|Scraper whereConnectorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Scraper whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Scraper whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Scraper whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Scraper whereHeaders($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Scraper whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Scraper whereMethod($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Scraper whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Scraper whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Scraper whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Scraper whereUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Scraper withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Scraper withoutTrashed()
 */
	class Scraper extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property string $id
 * @property string $name
 * @property string $url
 * @property string $logo
 * @property string|null $description
 * @property string $rss
 * @property \Illuminate\Support\Carbon|null $last_extracted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read mixed $primary_tag
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\News> $news
 * @property-read int|null $news_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Tag> $tags
 * @property-read int|null $tags_count
 * @method static \Database\Factories\SourceFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Source newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Source newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Source onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Source query()
 * @method static \Illuminate\Database\Eloquent\Builder|Source whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Source whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Source whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Source whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Source whereLastExtractedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Source whereLogo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Source whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Source whereRss($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Source whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Source whereUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Source withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Source withoutTrashed()
 */
	class Source extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $user_id
 * @property string $type
 * @property string $stripe_id
 * @property string $stripe_status
 * @property string|null $stripe_price
 * @property int|null $quantity
 * @property \Illuminate\Support\Carbon|null $trial_ends_at
 * @property \Illuminate\Support\Carbon|null $ends_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Laravel\Cashier\SubscriptionItem> $items
 * @property-read int|null $items_count
 * @property-read \App\Models\User|null $owner
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|Subscription active()
 * @method static \Illuminate\Database\Eloquent\Builder|Subscription canceled()
 * @method static \Illuminate\Database\Eloquent\Builder|Subscription ended()
 * @method static \Illuminate\Database\Eloquent\Builder|Subscription expiredTrial()
 * @method static \Laravel\Cashier\Database\Factories\SubscriptionFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Subscription incomplete()
 * @method static \Illuminate\Database\Eloquent\Builder|Subscription newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Subscription newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Subscription notCanceled()
 * @method static \Illuminate\Database\Eloquent\Builder|Subscription notOnGracePeriod()
 * @method static \Illuminate\Database\Eloquent\Builder|Subscription notOnTrial()
 * @method static \Illuminate\Database\Eloquent\Builder|Subscription onGracePeriod()
 * @method static \Illuminate\Database\Eloquent\Builder|Subscription onTrial()
 * @method static \Illuminate\Database\Eloquent\Builder|Subscription pastDue()
 * @method static \Illuminate\Database\Eloquent\Builder|Subscription query()
 * @method static \Illuminate\Database\Eloquent\Builder|Subscription recurring()
 * @method static \Illuminate\Database\Eloquent\Builder|Subscription whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Subscription whereEndsAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Subscription whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Subscription whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Subscription whereStripeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Subscription whereStripePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Subscription whereStripeStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Subscription whereTrialEndsAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Subscription whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Subscription whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Subscription whereUserId($value)
 */
	class Subscription extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property string $id
 * @property string $name
 * @property string|null $color
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Connector> $connectors
 * @property-read int|null $connectors_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Source> $sources
 * @property-read int|null $sources_count
 * @method static \Database\Factories\TagFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Tag newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Tag newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Tag onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Tag query()
 * @method static \Illuminate\Database\Eloquent\Builder|Tag whereColor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tag whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tag whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tag whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tag whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tag whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tag withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Tag withoutTrashed()
 */
	class Tag extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property string $id
 * @property string $firstname
 * @property string $lastname
 * @property string $username
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $date_of_birth
 * @property string|null $phone
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property mixed $password
 * @property string $preferred_language
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property string|null $stripe_id
 * @property string|null $pm_type
 * @property string|null $pm_last_four
 * @property string|null $trial_ends_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Calendar> $calendars
 * @property-read int|null $calendars_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Connector> $connectors
 * @property-read int|null $connectors_count
 * @property-read \App\Models\Subscription|null $currentSubscription
 * @property-read string $avatar
 * @property-read mixed $current_billing_plan
 * @property-read string $display_name
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Subscription> $subscriptions
 * @property-read int|null $subscriptions_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Tag[] $tags
 * @property-read int|null $tags_count
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|User hasExpiredGenericTrial()
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User onGenericTrial()
 * @method static \Illuminate\Database\Eloquent\Builder|User onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereDateOfBirth($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereFirstname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereLastname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePmLastFour($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePmType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePreferredLanguage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereStripeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereTrialEndsAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUsername($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|User withoutTrashed()
 */
	class User extends \Eloquent implements \Filament\Models\Contracts\FilamentUser, \Filament\Models\Contracts\HasAvatar, \Filament\Models\Contracts\HasName {}
}

