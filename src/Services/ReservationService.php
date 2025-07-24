<?php
namespace App\Services;

use PDO;
use Exception;

class ReservationService
{
    private PDO $db;

    public function __construct()
    {
        $this->db = DatabaseService::getInstance()->getConnection();
    }

    public function createReservation(int $userId, array $data): int
    {
        try {
            $this->db->beginTransaction();

            // Calcul du prix total
            $totalPrice = $this->calculateTotalPrice($data['rooms'], $data['date_start'], $data['date_end']);

            // Insertion de la réservation
            $stmt = $this->db->prepare("
                INSERT INTO reservations (
                    user_id, date_start, date_end, num_guests,
                    total_price, special_requests, status
                ) VALUES (
                    :user_id, :date_start, :date_end, :num_guests,
                    :total_price, :special_requests, 'pending'
                )
            ");

            $stmt->execute([
                'user_id' => $userId,
                'date_start' => $data['date_start'],
                'date_end' => $data['date_end'],
                'num_guests' => $data['num_guests'],
                'total_price' => $totalPrice,
                'special_requests' => $data['special_requests']
            ]);

            $reservationId = $this->db->lastInsertId();

            // Association des chambres à la réservation
            foreach ($data['rooms'] as $roomId) {
                $stmt = $this->db->prepare("
                    INSERT INTO reservation_rooms (reservation_id, room_id)
                    VALUES (:reservation_id, :room_id)
                ");
                $stmt->execute([
                    'reservation_id' => $reservationId,
                    'room_id' => $roomId
                ]);
            }

            $this->db->commit();
            return $reservationId;

        } catch (Exception $e) {
            $this->db->rollBack();
            throw new Exception('Erreur lors de la création de la réservation: ' . $e->getMessage());
        }
    }

    public function getReservationById(int $id): ?array
    {
        $stmt = $this->db->prepare("
            SELECT r.*, GROUP_CONCAT(rm.id) as room_ids
            FROM reservations r
            LEFT JOIN reservation_rooms rr ON r.id = rr.reservation_id
            LEFT JOIN rooms rm ON rr.room_id = rm.id
            WHERE r.id = ?
            GROUP BY r.id
        ");
        $stmt->execute([$id]);
        
        $reservation = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($reservation) {
            // Récupération des détails des chambres
            $reservation['rooms'] = $this->getRoomsByReservationId($id);
        }
        
        return $reservation ?: null;
    }

    public function getUserReservations(int $userId): array
    {
        $stmt = $this->db->prepare("
            SELECT r.*, GROUP_CONCAT(rm.number) as room_numbers
            FROM reservations r
            LEFT JOIN reservation_rooms rr ON r.id = rr.reservation_id
            LEFT JOIN rooms rm ON rr.room_id = rm.id
            WHERE r.user_id = ?
            GROUP BY r.id
            ORDER BY r.date_start DESC
        ");
        $stmt->execute([$userId]);
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function cancelReservation(int $id): void
    {
        $stmt = $this->db->prepare("
            UPDATE reservations
            SET status = 'cancelled'
            WHERE id = ?
        ");
        $stmt->execute([$id]);
    }

    private function calculateTotalPrice(array $roomIds, string $dateStart, string $dateEnd): float
    {
        // Calcul du nombre de nuits
        $nights = (strtotime($dateEnd) - strtotime($dateStart)) / (60 * 60 * 24);

        // Récupération du prix des chambres
        $stmt = $this->db->prepare("
            SELECT SUM(price_per_night) as total
            FROM rooms
            WHERE id IN (" . str_repeat('?,', count($roomIds) - 1) . "?)
        ");
        $stmt->execute($roomIds);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result['total'] * $nights;
    }

    private function getRoomsByReservationId(int $reservationId): array
    {
        $stmt = $this->db->prepare("
            SELECT r.*
            FROM rooms r
            JOIN reservation_rooms rr ON r.id = rr.room_id
            WHERE rr.reservation_id = ?
        ");
        $stmt->execute([$reservationId]);
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
} 