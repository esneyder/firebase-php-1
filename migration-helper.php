<?php

use Firebase\Factory;
use Firebase\ServiceAccount;
use GuzzleHttp\Psr7;
use GuzzleHttp\Psr7\Uri;

/** @noinspection ClassConstantCanBeUsedInspection */
if (!class_exists('\Firebase')) {
    class Firebase
    {
        /**
         * @deprecated since 3.0 Use {@link \Firebase\Factory} instead
         *
         * @see \Firebase\Factory::withCredentials()
         *
         * @param ServiceAccount $serviceAccount
         * @param mixed  $databaseUri
         *
         * @return \Firebase\V3\Firebase
         */
        public static function fromServiceAccount($serviceAccount, $databaseUri = null)
        {
            trigger_error('This method is deprecated. Use Firebase\Factory instead.', E_USER_DEPRECATED);

            /** @noinspection ExceptionsAnnotatingAndHandlingInspection */
            $serviceAccount = ServiceAccount::fromValue($serviceAccount);

            /** @noinspection CallableParameterUseCaseInTypeContextInspection */
            $databaseUri = $databaseUri
                ? Psr7\uri_for($databaseUri)
                : new Uri(sprintf('https://%s.firebaseio.com', $serviceAccount->getProjectId()));

            $factory = new Factory();
            $rc = new \ReflectionObject($factory);
            $rm = $rc->getMethod('getDefaultTokenHandler');
            $rm->setAccessible(true);

            $tokenHandler = $rm->invoke($factory, $serviceAccount);

            return new \Firebase\V3\Firebase($serviceAccount, $databaseUri, $tokenHandler);
        }
    }
}
