<?php

use Carbon\Carbon;
use Cmgmyr\Messenger\Models\Thread;
use Cmgmyr\Messenger\Models\Message;
use Cmgmyr\Messenger\Models\Participant;
use Illuminate\Support\Facades\Auth;
use Pusher\PusherInstance;

class MessagesController extends BaseController
{
	/**
	 * Just for testing - the user should be logged in. In a real
	 * app, please use standard authentication practices
	 */
	// public function __construct()
	// {
		// $user = User::find(1);
		// Auth::login($user);
	// }

	/**
	 * Show all of the message threads to the user
	 *
	 * @return mixed
	 */
	public function index()
	{
		$currentUserId = Auth::user()->id;

		// All threads, ignore deleted/archived participants
		// $threads = Thread::getAllLatest();

		// All threads that user is participating in
		$threads = Thread::forUser($currentUserId);

		// All threads that user is participating in, with new messages
		// $threads = Thread::forUserWithNewMessages($currentUserId);

		return View::make('messenger.index', compact('threads', 'currentUserId'));
	}

	/**
	 * Shows a message thread
	 *
	 * @param $id
	 * @return mixed
	 */
	public function show($id)
	{
		$thread = Thread::findOrFail($id);

		// show current user in list if not a current participant
		//$users = User::whereNotIn('id', $thread->participantsUserIds())->get();

		// don't show the current user in list
		$userId = Auth::user()->id;
		$users = User::whereNotIn('id', $thread->participantsUserIds($userId))->get();

		$thread->markAsRead($userId);

		return View::make('messenger.show', compact('thread', 'users'));
	}

	/**
	 * Creates a new message thread
	 *
	 * @return mixed
	 */
	public function create()
	{
		$users = User::where('id', '!=', Auth::id())->get();

		return View::make('messenger.create', compact('users'));
	}

	/**
	 * Stores a new message thread
	 *
	 * @return mixed
	 */
	public function store()
	{
		$input = Input::all();

		$usernameId = array_only($input, array('recipients'));

		$thread = Thread::create(
			[
				'subject' => $input['subject'],
			]
		);

		// Message
		Message::create(
			[
				'thread_id' => $thread->id,
				'user_id'   => Auth::user()->id,
				'body'      => $input['message'],
			]
		);

		// Sender
		Participant::create(
			[
				'thread_id' => $thread->id,
				'user_id'   => Auth::user()->id,
				'last_read' => new Carbon
			]
		);

		// Recipients
		if (Input::has('recipients')) {
			$thread->addParticipants($usernameId['recipients']);
		}

		return Redirect::to('messages/');
	}

	/**
	 * Adds a new message to a current thread
	 *
	 * @param $id
	 * @return mixed
	 */
	public function update($id)
	{
		$thread = Thread::findOrFail($id);

		$thread->activateAllParticipants();

		// Message
		Message::create(
			[
				'thread_id' => $thread->id,
				'user_id'   => Auth::id(),
				'body'      => Input::get('message'),
			]
		);

		// Add replier as a participant
		$participant = Participant::firstOrCreate(
			[
				'thread_id' => $thread->id,
				'user_id'   => Auth::user()->id
			]
		);
		$participant->last_read = new Carbon;
		$participant->save();

		// Recipients
		if (Input::has('recipients')) {
			$thread->addParticipants(Input::get('recipients'));
		}

		return Redirect::to('messages/' . $id);
	}

	public function chat()
	{
		// return Response::json(Input::get('message', 'channel'));
		// $input = Input::all();

		// App::make('Pusher')->trigger(
		// $input['channel'],
		// 'PostWasPublished',
		// ['title' => $input['message']]
		// );
		// return 'success';
		return View::make('messenger.chat');
	}

}