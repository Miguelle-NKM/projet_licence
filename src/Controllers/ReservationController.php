<?php
namespace App\Controllers;

use App\Services\ReservationService;
use App\Services\RoomService;
use Exception;

class ReservationController
{
    private ReservationService $reservationService;
    private RoomService $roomService;

    public function __construct()
    {
        $this->reservationService = new ReservationService();
        $this->roomService = new RoomService();
    }

    public function index()
    {
        $title = 'Réservations';
        $availableRooms = $this->roomService->getAvailableRooms();
        
        ob_start();
        require __DIR__ . '/../Views/templates/reservation/index.php';
        $content = ob_get_clean();
        
        require __DIR__ . '/../Views/templates/layout.php';
    }

    public function create()
    {
        try {
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                throw new Exception('Méthode non autorisée');
            }

            // Vérification de l'authentification
            if (!isset($_SESSION['user_id'])) {
                $_SESSION['error'] = 'Vous devez être connecté pour faire une réservation';
                header('Location: /login');
                exit;
            }

            // Validation des données
            $data = $this->validateReservationData($_POST);

            // Création de la réservation
            $reservationId = $this->reservationService->createReservation(
                $_SESSION['user_id'],
                $data
            );

            $_SESSION['success'] = 'Réservation créée avec succès';
            header('Location: /reservation/confirmation/' . $reservationId);
            exit;

        } catch (Exception $e) {
            $_SESSION['error'] = $e->getMessage();
            header('Location: /reservation');
            exit;
        }
    }

    public function show(int $id)
    {
        try {
            $reservation = $this->reservationService->getReservationById($id);
            
            if (!$reservation) {
                throw new Exception('Réservation non trouvée');
            }

            // Vérification des droits d'accès
            if ($reservation['user_id'] !== $_SESSION['user_id'] && !isset($_SESSION['is_admin'])) {
                throw new Exception('Accès non autorisé');
            }

            $title = 'Détails de la réservation';
            
            ob_start();
            require __DIR__ . '/../Views/templates/reservation/show.php';
            $content = ob_get_clean();
            
            require __DIR__ . '/../Views/templates/layout.php';

        } catch (Exception $e) {
            $_SESSION['error'] = $e->getMessage();
            header('Location: /dashboard');
            exit;
        }
    }

    public function cancel(int $id)
    {
        try {
            $reservation = $this->reservationService->getReservationById($id);
            
            if (!$reservation) {
                throw new Exception('Réservation non trouvée');
            }

            // Vérification des droits d'accès
            if ($reservation['user_id'] !== $_SESSION['user_id'] && !isset($_SESSION['is_admin'])) {
                throw new Exception('Accès non autorisé');
            }

            $this->reservationService->cancelReservation($id);
            
            $_SESSION['success'] = 'Réservation annulée avec succès';
            header('Location: /dashboard');
            exit;

        } catch (Exception $e) {
            $_SESSION['error'] = $e->getMessage();
            header('Location: /dashboard');
            exit;
        }
    }

    private function validateReservationData(array $data): array
    {
        $errors = [];

        // Validation des dates
        $dateStart = strtotime($data['date_start'] ?? '');
        $dateEnd = strtotime($data['date_end'] ?? '');
        
        if (!$dateStart) {
            $errors[] = 'La date d\'arrivée est requise';
        }
        
        if (!$dateEnd) {
            $errors[] = 'La date de départ est requise';
        }
        
        if ($dateStart && $dateEnd && $dateStart >= $dateEnd) {
            $errors[] = 'La date de départ doit être postérieure à la date d\'arrivée';
        }

        // Validation du nombre de personnes
        $numGuests = filter_var($data['num_guests'] ?? 0, FILTER_VALIDATE_INT);
        if (!$numGuests || $numGuests < 1) {
            $errors[] = 'Le nombre de personnes est invalide';
        }

        // Validation des chambres sélectionnées
        if (!isset($data['rooms']) || !is_array($data['rooms']) || empty($data['rooms'])) {
            $errors[] = 'Veuillez sélectionner au moins une chambre';
        }

        if (!empty($errors)) {
            throw new Exception(implode('<br>', $errors));
        }

        return [
            'date_start' => date('Y-m-d', $dateStart),
            'date_end' => date('Y-m-d', $dateEnd),
            'num_guests' => $numGuests,
            'rooms' => $data['rooms'],
            'special_requests' => filter_var($data['special_requests'] ?? '', FILTER_SANITIZE_STRING)
        ];
    }
} 