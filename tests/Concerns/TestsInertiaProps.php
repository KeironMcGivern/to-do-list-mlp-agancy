<?php

namespace Tests\Concerns;

use Illuminate\Support\Arr;
use Illuminate\Testing\TestResponse;
use PHPUnit\Framework\Assert;

trait TestsInertiaProps
{
    private $componentData = [];

    public function getComponentData($data)
    {
        if (! $this->componentData) {
            $this->componentData = json_decode(
                json_encode($data['components']),
                JSON_OBJECT_AS_ARRAY
            );
        }

        return $this->componentData;
    }

    public function bootTestsInertiaProps()
    {
        TestResponse::macro('assertComponentIs', function ($value) {
            $page = json_decode(json_encode($this->original->getData()['page']), JSON_OBJECT_AS_ARRAY);
            Assert::assertTrue(Arr::has($page, 'component'));
            Assert::assertEquals($page['component'], $value);

            return $this;
        });

        $this->registerPropMacro();
        $this->registerComponentCollector();
        $this->registerSharedPropCollector();
        $this->registerAssertSeeComponent();
        $this->registerAssertDontSeeComponent();
        $this->registerAssertPropValue();
        $this->registerAssertSharedPropValue();
        $this->registerAssertHasProp();
        $this->registerAssertHasSharedProp();
        $this->registerAssertPropCount();
        $this->registerAssertSeeSelector();
        $this->registerAssertDontSeeSelector();
    }

    private function registerPropMacro()
    {
        TestResponse::macro('props', function ($key = null) {
            $props = json_decode(json_encode($this->original->getData()['page']['props']), JSON_OBJECT_AS_ARRAY);

            if ($key) {
                return Arr::get($props, $key);
            }

            return $props;
        });
    }

    private function registerComponentCollector()
    {
        TestResponse::macro('components', function ($selector = null) {
            $components = json_decode(
                json_encode($this->original ? $this->original->getData()['components'] : []),
                JSON_OBJECT_AS_ARRAY
            );

            if ($selector) {
                return Arr::get($components, $selector);
            }

            return $components;
        });
    }

    private function registerSharedPropCollector()
    {
        TestResponse::macro('sharedProps', function ($key = null) {
            $props = json_decode(
                json_encode($this->original ? $this->original->getData()['shared'] : []),
                JSON_OBJECT_AS_ARRAY
            );

            if ($key) {
                return Arr::get($props, $key);
            }

            return $props;
        });
    }

    private function registerAssertSharedPropValue()
    {
        TestResponse::macro('assertSharedPropValue', function ($key, $value) {
            $props = $this->sharedProps($key);

            if (is_callable($value)) {
                $value($props);
            } else {
                Assert::assertEquals($props[$key], $value);
            }

            return $this;
        });
    }

    private function registerAssertPropValue()
    {
        TestResponse::macro('assertPropValue', function ($key, $value) {
            $this->assertHasProp($key);

            if (is_callable($value)) {
                $value($this->props($key));
            } else {
                Assert::assertEquals($this->props($key), $value);
            }

            return $this;
        });
    }

    private function registerAssertHasSharedProp()
    {
        TestResponse::macro('assertHasSharedProp', function ($key) {
            $props = $this->sharedProps($key);
            Assert::assertTrue(Arr::has($props, $key), "Shared prop [{$key}] not found");

            return $this;
        });
    }

    private function registerAssertHasProp()
    {
        TestResponse::macro('assertHasProp', function ($key) {
            Assert::assertTrue(Arr::has($this->props(), $key));

            return $this;
        });
    }

    private function registerAssertPropCount()
    {
        TestResponse::macro('assertPropCount', function ($key, $count) {
            $this->assertHasProp($key);

            Assert::assertCount($count, $this->props($key));

            return $this;
        });
    }

    private function registerAssertSeeSelector()
    {
        TestResponse::macro('assertSeeSelector', function ($selector) {
            $component = $this->components($selector);

            Assert::assertTrue($component['selector'] === $selector);
            $this->assertSee('supersonic="'.$selector.'"', false);

            return $this;
        });
    }

    private function registerAssertDontSeeSelector()
    {
        TestResponse::macro('assertDontSeeSelector', function ($selector) {
            $component = $this->components($selector);

            Assert::assertNull($component);
            $this->assertDontSee('supersonic="'.$selector.'"');

            return $this;
        });
    }

    private function registerAssertSeeComponent()
    {
        TestResponse::macro('assertSeeComponent', function ($value, $selector = null) {
            $components = Arr::where(
                $this->components(),
                function ($component) use ($value) {
                    return $component['component'] === $value;
                }
            );

            Assert::assertTrue(count($components) > 0);

            if ($selector) {
                $this->assertSeeSelector($selector);
            }

            return $this;
        });
    }

    private function registerAssertDontSeeComponent()
    {
        TestResponse::macro('assertDontSeeComponent', function ($value, $selector = null) {
            $components = Arr::where(
                $this->components(),
                function ($component) use ($value) {
                    return $component['component'] === $value;
                }
            );

            Assert::assertTrue(count($components) === 0);

            if ($selector) {
                $this->assertDontSeeSelector($selector);
            }

            return $this;
        });
    }
}
