<?php

namespace SESP\PropertyAnnotators;

use SESP\AppFactory;
use SESP\PropertyAnnotator;
use SMW\DIProperty;
use SMW\SemanticData;
use SMWDataItem as DataItem;
use SMWDINumber as DINumber;

/**
 * @private
 * @ingroup SESP
 *
 * @license GPL-2.0-or-later
 * @since 2.0
 *
 * @author mwjames
 */
class PageIDPropertyAnnotator implements PropertyAnnotator {

	/**
	 * Predefined property ID
	 */
	const PROP_ID = '___PAGEID';

	/**
	 * @var AppFactory
	 */
	private $appFactory;

	/**
	 * @since 2.0
	 *
	 * @param AppFactory $appFactory
	 */
	public function __construct( AppFactory $appFactory ) {
		$this->appFactory = $appFactory;
	}

	/**
	 * @since 2.0
	 *
	 * {@inheritDoc}
	 */
	public function isAnnotatorFor( DIProperty $property ) {
		return $property->getKey() === self::PROP_ID;
	}

	/**
	 * @since 2.0
	 *
	 * {@inheritDoc}
	 */
	public function addAnnotation( DIProperty $property, SemanticData $semanticData ) {
		$page = $this->appFactory->newWikiPage(
			$semanticData->getSubject()->getTitle()
		);

		$pageID = $page->getId();
		$dataItem = null;

		if ( is_integer( $pageID ) && $pageID > 0 ) {
			$dataItem = new DINumber( $pageID );
		}

		if ( $dataItem instanceof DataItem ) {
			$semanticData->addPropertyObjectValue( $property, $dataItem );
		}
	}

}
