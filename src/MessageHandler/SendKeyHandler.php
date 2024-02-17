<?php

namespace App\MessageHandler;

use App\Message\SendKey;
use App\Repository\UserRepository;
use Random\RandomException;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Messenger\Exception\RecoverableMessageHandlingException;
use Symfony\Component\Messenger\Exception\UnrecoverableMessageHandlingException;

#[AsMessageHandler]
class SendKeyHandler
{
    public function __construct(
        private UserRepository $userRepository
    )
    {
    }

    /**
     * @throws RandomException
     */
    public function __invoke(SendKey $message): void
    {
        throw new UnrecoverableMessageHandlingException ('This is a test');

        $user = $this->userRepository->find($message->getUserId());

        if (!$user) {
            return;
        }

        $this->sendEmail($user->getEmail(), $this->getKey());
    }

    /**
     * @throws RandomException
     */
    private function getKey(): int
    {
        // generate key
        sleep(5);
        return random_int(1000, 9999);

    }

    private function sendEmail(string $email, int $key): void
    {
        file_put_contents('email'.$key.'.txt', $email . ' ' . $key);
    }


}
