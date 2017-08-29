<?php
/**
 * Created by PhpStorm.
 * User: LucaFisso
 * Date: 10/08/2017
 * Time: 17:19
 */

namespace TelegramBot\Parameters;

use ReflectionClass;

abstract class BaseParameter
{
	private function toArray()
	{
		$properties = [];

		foreach($this->getAllClasses($this) as $class)
		{
			$properties = array_merge($properties, $this->getAllProperties($class, $this));
		}

		return array_filter($properties, function($var) {
			return $var !== null;
		});
	}

	/**
	 * @param ReflectionClass $reflect
	 * @param                 $object
	 * @return array
	 */
	private function getAllProperties($reflect, $object)
	{
		$properties = [];
		foreach($reflect->getProperties() as $prop)
		{
			$prop->setAccessible(true);

			$name = $prop->getName();
			$value = $prop->getValue($object);

			$properties[$name] = $value;
		}
		return $properties;
	}

	private function getAllClasses($object)
	{
		$reflect = new ReflectionClass($object);

		$parents = [$reflect];

		$parent = $reflect->getParentClass();
		while($parent !== false)
		{
			$parents[] = $parent;
			$parent = $parent->getParentClass();
		}

		return $parents;
	}
}