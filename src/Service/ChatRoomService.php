<?php
/* */
namespace App\Service;

use App\Entity\ChatRoom;
use Doctrine\ORM\EntityManagerInterface;

class ChatRoomService
{
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function getOrCreateChatRoom(string $matchId): ChatRoom
    {
        $repository = $this->em->getRepository(ChatRoom::class);

        $chatRoom = $repository->findOneBy(['matchId' => $matchId]);

        if (!$chatRoom) {
            $chatRoom = new ChatRoom();
            $chatRoom->setMatchId($matchId);

            $this->em->persist($chatRoom);
            $this->em->flush();
        }

        return $chatRoom;
    }
}
