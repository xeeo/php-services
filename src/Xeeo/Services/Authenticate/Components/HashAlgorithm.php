<?php
/**
 * HashAlgorithm.php
 *
 * PHP version 5.5+
 *
 * @module    Authenticate
 * @package   Xeeo\Services\Authenticate\Components
 * @category  Services
 * @author    "Raul Geana" <geana.raul@gmail.com>
 * @copyright 2014 Geana Raul Andrei
 * @license   Proprietary license.
 */

namespace Xeeo\Services\Authenticate\Components;

use \Xeeo\Services\Authenticate\Exceptions\Authenticate as AuthenticateException;

trait HashAlgorithm {

	private $hashAlgorithm = PASSWORD_DEFAULT;
	private $hashSalt      = '';
	private $hashCost      = 10;

	public function getHashAlgorithm() {
		return (int) $this->hashAlgorithm;
	}

	public function setHashAlgorithm($hashAlgorithm) {
		$this->hashAlgorithm = (int) $hashAlgorithm;

        return $this;
	}

	public function getHashSalt() {
		return (string) $this->hashSalt;
	}

	public function setHashSalt($hashSalt) {
		$this->hashSalt = (string) $hashSalt;

		return $this;
	}

	public function getHashCost() {
		return (int) $this->hashCost;
	}

	public function setHashCost($hashCost) {
		$this->hashCost = (int) $hashCost;

		return $this;
	}

    public function hashPassword($plainPassword) {
        return password_hash($plainPassword, $this->getHashAlgorithm());
    }

    /**
     * Generates a random Password
     *
     * @param int $length password length
     *
     * @return string
     */
    public function generatePassword($length = 10)
    {
        $password    = '';
        $values      = array_merge(range(0, 9), range('a', 'z'), array('$', ':', '?', '%', '&'));
        $countValues = count($values) - 1;

        for ($i = 1; $i <= $length; $i++) {
            $password .= $values[rand(0, $countValues)];
        }

        return $password;
    }

    public function validatePassword($plainPassword, $hashedPassword) {
        if (false === password_verify($plainPassword, $hashedPassword)) {
            throw new AuthenticateException(
                AuthenticateException::MSG_WRONG_PASSWORD,
                AuthenticateException::CODE_WRONG_PASSWORD
            );
        }

        return true;
    }

}
