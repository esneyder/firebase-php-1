<?php

namespace {
    use Firebase\Factory;
    use Firebase\ServiceAccount;
    use GuzzleHttp\Psr7;
    use GuzzleHttp\Psr7\Uri;

    /* @noinspection ClassConstantCanBeUsedInspection */
    if (!class_exists('\Firebase')) {
        class Firebase
        {
            /**
             * @deprecated since 3.0 Use {@link \Firebase\Factory} instead
             * @see \Firebase\Factory::withCredentials()
             *
             * @param ServiceAccount $serviceAccount
             * @param mixed  $databaseUri
             *
             * @return \Firebase\Project
             */
            public static function fromServiceAccount($serviceAccount, $databaseUri = null)
            {
                trigger_error(__METHOD__ . ' is deprecated. Use Firebase\Factory instead.', E_USER_DEPRECATED);

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

                return new Firebase\Project($serviceAccount, $databaseUri, $tokenHandler);
            }
        }
    }
}

namespace Firebase\V3 {
    use Firebase\Factory;
    use Firebase\Project;
    use Firebase\ServiceAccount;
    use GuzzleHttp\Psr7;
    use GuzzleHttp\Psr7\Uri;

    /* @noinspection ClassConstantCanBeUsedInspection */
    if (!class_exists('\Firebase\V3\Firebase')) {
        /**
         * @deprecated since 3.0 use {@link \Firebase\Project} instead
         */
        class Firebase extends Project
        {
            /**
             * @deprecated since 3.0 Use {@link \Firebase\Factory} instead
             * @see \Firebase\Factory::withCredentials()
             *
             * @param mixed $serviceAccount Service Account (ServiceAccount instance, JSON, array, path to JSON file)
             * @param mixed $databaseUri
             *
             * @return Project
             */
            public static function fromServiceAccount($serviceAccount, $databaseUri = null)
            {
                trigger_error(__METHOD__ . ' is deprecated. Use Firebase\Factory instead.', E_USER_DEPRECATED);

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

                return new Project($serviceAccount, $databaseUri, $tokenHandler);
            }
        }
    }
}
