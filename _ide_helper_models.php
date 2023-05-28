<?php

// @formatter:off
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * App\Models\Mail
 *
 * @property int $id
 * @property string $to
 * @property string|null $subject
 * @property mixed|null $cc
 * @property string|null $body
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Mail newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Mail newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Mail query()
 * @method static \Illuminate\Database\Eloquent\Builder|Mail whereBody($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Mail whereCc($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Mail whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Mail whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Mail whereSubject($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Mail whereTo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Mail whereUpdatedAt($value)
 */
	class Mail extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\MailAttachment
 *
 * @property int $id
 * @property int $mail_id
 * @property string $attachment
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|MailAttachment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MailAttachment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MailAttachment query()
 * @method static \Illuminate\Database\Eloquent\Builder|MailAttachment whereAttachment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MailAttachment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MailAttachment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MailAttachment whereMailId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MailAttachment whereUpdatedAt($value)
 */
	class MailAttachment extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\User
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string $role
 * @property string|null $dob
 * @property string|null $image
 * @property string|null $gender
 * @property string|null $designation
 * @property int|null $is_manager
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $access_token
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Laravel\Sanctum\PersonalAccessToken> $tokens
 * @property-read int|null $tokens_count
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|User isAdmin()
 * @method static \Illuminate\Database\Eloquent\Builder|User isEmployee()
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereAccessToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereDesignation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereDob($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereGender($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereIsManager($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 */
	class User extends \Eloquent {}
}

