<?php

namespace App\Services;

use PDO;
use Exception;

class RoomService
{
    private PDO $db;

    public function __construct()
    {
        $this->db = DatabaseService::getInstance()->getConnection();
    }

    public function getAllRooms(): array
    {
        $stmt = $this->db->query("
            SELECT *
            FROM rooms
            ORDER BY number ASC
        ");

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAvailableRooms(string $dateStart = null, string $dateEnd = null): array
    {
        $query = "
            SELECT r.*
            FROM rooms r
            WHERE r.is_available = 1
        ";

        $params = [];

        if ($dateStart && $dateEnd) {
            $query .= " AND r.id NOT IN (
                SELECT DISTINCT rr.room_id
                FROM reservation_rooms rr
                JOIN reservations res ON rr.reservation_id = res.id
                WHERE res.status != 'cancelled'
                AND (
                    (res.date_start BETWEEN ? AND ?)
                    OR (res.date_end BETWEEN ? AND ?)
                    OR (res.date_start <= ? AND res.date_end >= ?)
                )
            )";

            $params = [
                $dateStart,
                $dateEnd,
                $dateStart,
                $dateEnd,
                $dateStart,
                $dateEnd
            ];
        }

        $query .= " ORDER BY r.price_per_night ASC";

        $stmt = $this->db->prepare($query);
        $stmt->execute($params);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getRoomById(int $id): ?array
    {
        $stmt = $this->db->prepare("
            SELECT *
            FROM rooms
            WHERE id = ?
        ");
        $stmt->execute([$id]);

        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    public function getRoomsByType(string $type): array
    {
        $stmt = $this->db->prepare("
            SELECT *
            FROM rooms
            WHERE type = ?
            ORDER BY price_per_night ASC
        ");
        $stmt->execute([$type]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateRoomAvailability(int $id, bool $isAvailable): void
    {
        $stmt = $this->db->prepare("
            UPDATE rooms
            SET is_available = ?
            WHERE id = ?
        ");
        $stmt->execute([$isAvailable, $id]);
    }

    public function createRoom(array $data): int
    {
        try {
            $stmt = $this->db->prepare("
                INSERT INTO rooms (
                    number, type, capacity, price_per_night,
                    description, is_available
                ) VALUES (
                    :number, :type, :capacity, :price_per_night,
                    :description, :is_available
                )
            ");

            $stmt->execute([
                'number' => $data['number'],
                'type' => $data['type'],
                'capacity' => $data['capacity'],
                'price_per_night' => $data['price_per_night'],
                'description' => $data['description'],
                'is_available' => $data['is_available'] ?? true
            ]);

            return (int)$this->db->lastInsertId();
        } catch (Exception $e) {
            throw new Exception('Erreur lors de la création de la chambre: ' . $e->getMessage());
        }
    }

    public function updateRoom(int $id, array $data): void
    {
        try {
            $stmt = $this->db->prepare("
                UPDATE rooms
                SET number = :number,
                    type = :type,
                    capacity = :capacity,
                    price_per_night = :price_per_night,
                    description = :description,
                    is_available = :is_available
                WHERE id = :id
            ");

            $stmt->execute([
                'id' => $id,
                'number' => $data['number'],
                'type' => $data['type'],
                'capacity' => $data['capacity'],
                'price_per_night' => $data['price_per_night'],
                'description' => $data['description'],
                'is_available' => $data['is_available'] ?? true
            ]);
        } catch (Exception $e) {
            throw new Exception('Erreur lors de la mise à jour de la chambre: ' . $e->getMessage());
        }
    }

    public function deleteRoom(int $id): void
    {
        // Vérifier si la chambre a des réservations actives
        $stmt = $this->db->prepare("
            SELECT COUNT(*) as count
            FROM reservation_rooms rr
            JOIN reservations r ON rr.reservation_id = r.id
            WHERE rr.room_id = ?
            AND r.status != 'cancelled'
            AND r.date_end >= CURRENT_DATE
        ");
        $stmt->execute([$id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result['count'] > 0) {
            throw new Exception('Impossible de supprimer une chambre avec des réservations actives');
        }

        $stmt = $this->db->prepare("DELETE FROM rooms WHERE id = ?");
        $stmt->execute([$id]);
    }
}
