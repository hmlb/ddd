<?php
declare(strict_types = 1);

namespace HMLB\DDD\Message;

use HMLB\DDD\Entity\Identity;

/**
 * A simple implementation of a named message.
 *
 * The name will be based on the class name of the message. e.g. : DoSomethingImportant => do_something_imporant
 *
 * @author Hugues Maignol <hugues@hmlb.fr>
 */
class Message implements MessageInterface
{
    /**
     * An Identifier can be issued by middleware for command persistance.
     *
     * @var Identity
     */
    private $id;

    /**
     * @var string
     */
    private static $_messageName;

    /**
     * @return string
     */
    public function __toString(): string
    {
        return self::messageName();
    }

    /**
     * @return Identity
     */
    public function getId(): Identity
    {
        return $this->id;
    }

    /**
     * Guesses the message name from the class name.
     * Keeps it in memory after first call.
     * If you want to optimize performance, override this method.
     *
     * @return string
     */
    public static function messageName(): string
    {
        if (null === self::$_messageName) {
            $classSlices = explode('\\', get_called_class());
            self::$_messageName = strtolower(preg_replace('/([^A-Z])([A-Z])/', '$1_$2', array_pop($classSlices)));
        }

        return self::$_messageName;
    }
}
