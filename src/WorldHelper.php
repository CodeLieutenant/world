<?php

namespace Nnjeim\World;

use Exception;
use RuntimeException;

class WorldHelper
{
    private array $availableActions = [
        'countries' => [
            'actionBasePath' => 'Nnjeim\\World\\Actions\\Country',
            'action' => 'index',
        ],
        'states' => [
            'actionBasePath' => 'Nnjeim\\World\\Actions\\State',
            'action' => 'index',
        ],
        'cities' => [
            'actionBasePath' => 'Nnjeim\\World\\Actions\\City',
            'action' => 'index',
        ],
        'timezones' => [
            'actionBasePath' => 'Nnjeim\\World\\Actions\\Timezone',
            'action' => 'index',
        ],
        'currencies' => [
            'actionBasePath' => 'Nnjeim\\World\\Actions\\Currency',
            'action' => 'index',
        ],
        'languages' => [
            'actionBasePath' => 'Nnjeim\\World\\Actions\\Language',
            'action' => 'index',
        ],
    ];

    /**
     * @param $function
     * @param array $args
     * @return mixed
     * @throws Exception
     */
    public function __call($function, array $args = [])
    {
        [$actionBasePath, $action] = $this->fetchAction($function);

        return app($this->formActionClass($actionBasePath, $action))->execute(!empty($args) ? $args[0] : []);
    }

    /**
     * @param string $function
     * @return array
     * @throws Exception
     */
    private function fetchAction(string $function): array
    {
        if (!array_key_exists(strtolower($function), $this->availableActions)) {
            throw new RuntimeException('Method not found!');
        }

        ['actionBasePath' => $actionBasePath, 'action' => $action] = $this->availableActions[strtolower($function)];

        return [$actionBasePath, $action];
    }

    /**
     * @param string $actionBasePath
     * @param string $function
     * @return string
     */
    private function formActionClass(string $actionBasePath, string $function): string
    {
        return implode('\\', [$actionBasePath, ucfirst($function)]) . 'Action';
    }

    /**
     * @param string $requestLocale
     * @return $this
     */
    public function setLocale(string $requestLocale): self
    {
        $setLocale = in_array($requestLocale, config('world.accepted_locales'), true)
            ? $requestLocale
            : config('app.fallback_locale');

        app()->setLocale($setLocale);

        return $this;
    }
}
