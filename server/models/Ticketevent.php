<?php
/**
 * @api {OBJECT} TicketEvent TicketEvent
 * @apiGroup Data Structures
 * @apiParam {String}  type The type of the ticket event.
 * @apiParam {String}  content The content of the ticket event.
 * @apiParam {Object}  author The author of the ticket event.
 * @apiParam {Number}  author.id The author's id of the ticket event.
 * @apiParam {String}  author.name The author's name of the ticket event.
 * @apiParam {String}  author.email The author's email of the ticket event.
 * @apiParam {String}  author.profilePic The author's profilePic of the ticket event.
 * @apiParam {Boolean}  author.staff The boolean to know if the author is staff or not.
 * @apiParam {String}  date The date of the ticket event.
 * @apiParam {String}  file The file of the ticket event.
 */

class Ticketevent extends DataStore {
    const TABLE = 'ticketevent';

    const COMMENT = 'COMMENT';
    const ASSIGN = 'ASSIGN';
    const UN_ASSIGN = 'UN_ASSIGN';
    const CLOSE = 'CLOSE';
    const RE_OPEN = 'RE_OPEN';
    const DEPARTMENT_CHANGED = 'DEPARTMENT_CHANGED';
    const PRIORITY_CHANGED = 'PRIORITY_CHANGED';

    private static function getEventTypes() {
        return [
            'COMMENT',
            'ASSIGN',
            'UN_ASSIGN',
            'CLOSE',
            'RE_OPEN',
            'DEPARTMENT_CHANGED',
            'PRIORITY_CHANGED'
        ];
    }

    public static function getEvent($type) {
        if (!in_array($type, Ticketevent::getEventTypes())) {
            return new NullDataStore();
        }

        $ticketEvent = new Ticketevent();
        $ticketEvent->setProperties([
            'type' => $type
        ]);

        return $ticketEvent;
    }

    public static function getProps() {
        return [
            'type',
            'content',
            'file',
            'authorUser',
            'authorStaff',
            'date'
        ];
    }

    public function getAuthor() {
        if($this->authorUser) {
            return $this->authorUser;
        }

        if($this->authorStaff) {
            return $this->authorStaff;
        }

        return new NullDataStore();
    }

    public function toArray() {
        $user = ($this->authorStaff) ? $this->authorStaff : $this->authorUser;

        return [
            'type' => $this->type,
            'ticketNumber' => $this->ticket->ticketNumber,
            'author' => [
                'name' => $user ? $user->name : null,
                'staff' => $user instanceOf Staff,
                'id' => $user ? $user->id : null
            ]
        ];
    }
}