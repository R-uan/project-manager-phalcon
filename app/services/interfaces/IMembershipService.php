<?php

interface IMembershipService {
  public function findUserMemberships(int $userId);
}