<?php

namespace App\MessageHandler;

use App\Message\SmsKey;
use App\Repository\UserRepository;
use Random\RandomException;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class SmsKeyHandler
{
    public function __construct(
        private UserRepository $userRepository
    )
    {
    }

    /**
     * @throws RandomException
     */
    public function __invoke(SmsKey $message): void
    {
        $user = $this->userRepository->find($message->getUserId());

        if (!$user) {
            return;
        }

        $this->randomError();

        $this->sendSms($user->getEmail(), $this->getKey());
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

    private function sendSms(string $phone, int $key): void
    {
        file_put_contents('sms'.$key.'.txt', $phone . ' ' . $key);
    }


    # function for random generate error

    /**
     * @throws RandomException
     */
    private function randomError(): void
    {
        $random = random_int(1, 10);
        if ($random > 2) {
            throw new RandomException('This is a test');
        }
    }
}
