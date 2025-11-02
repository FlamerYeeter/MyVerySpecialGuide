<?php

namespace App\Services;

/**
 * FirestoreAdminService (stub)
 *
 * The project previously used Firestore via REST and a service account. Firebase/Firestore
 * was removed from the codebase per project requirements. This lightweight stub keeps
 * the same public method signatures but returns safe defaults so dependent controllers
 * and routes continue to function without attempting network calls to Google APIs.
 */
class FirestoreAdminService
{
    public function __construct()
    {
        // Intentionally empty. Use logger() if needed to surface calls during migration.
    }

    public function isAdmin(string $firebaseUid): bool
    {
        logger()->warning('FirestoreAdminService::isAdmin called but Firestore integration has been removed.');
        return false;
    }

    public function listAssignments(): array
    {
        logger()->warning('FirestoreAdminService::listAssignments called but Firestore integration has been removed.');
        return [];
    }

    public function listUsers(): array
    {
        logger()->warning('FirestoreAdminService::listUsers called but Firestore integration has been removed.');
        return [];
    }

    public function assign(string $firebaseUid, ?string $email = null, string $assignedBy = ''): bool
    {
        logger()->warning('FirestoreAdminService::assign called but Firestore integration has been removed.');
        return false;
    }

    public function revoke(string $firebaseUid, string $revokedBy = ''): bool
    {
        logger()->warning('FirestoreAdminService::revoke called but Firestore integration has been removed.');
        return false;
    }

    public function getSavedJobs(string $firebaseUid): array
    {
        logger()->warning('FirestoreAdminService::getSavedJobs called but Firestore integration has been removed.');
        return [];
    }

    public function setSavedJobs(string $firebaseUid, array $jobIds): bool
    {
        logger()->warning('FirestoreAdminService::setSavedJobs called but Firestore integration has been removed.');
        return false;
    }

    // Keep a base64 helper (no-op) for compatibility if referenced
    private function base64UrlEncode(string $input): string
    {
        return rtrim(strtr(base64_encode($input), '+/', '-_'), '=');
    }
}
