<?php
defined('C5_EXECUTE') or die("Access Denied.");
/**
 * @var $attributes \Concrete\Core\Attribute\AttributeKeyInterface[]
 */
?>

<?php $form = Core::make('helper/form'); ?>

<ul class="item-select-list ccm-attribute-list-wrapper">
    <?php
    foreach($attributes as $attribute) {
        $key = $attribute->getAttributeKey();
        $controller = $key->getController();
        $formatter = $controller->getIconFormatter(); ?>

        <li class="ccm-attribute" id="akID_<?=$key->getAttributeKeyID()?>">
            <a href="<?=$view->controller->getEditAttributeKeyURL($key)?>" title="<?php echo t('Handle')?>: <?php echo $key->getAttributeKeyHandle(); ?>">
                <?=$formatter->getListIconElement()?>
                <?=$key->getAttributeKeyDisplayName()?>
            </a>
        </li>

    <? } ?>
</ul>

<?php if (isset($types) && is_array($types) && count($types) > 0) { ?>

    <h4><?=t('Add Attribute Type')?></h4>

    <div class="btn-group">
        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
            <?=t('Choose')?> <span class="caret"></span>
        </button>
        <ul class="dropdown-menu">
            <? foreach($types as $type) {
                $controller = $type->getController();
                /**
                 * @var $formatter \Concrete\Core\Attribute\IconFormatterInterface
                 */
                $formatter = $controller->getIconFormatter(); ?>
                <li><a href="<?=$view->controller->getAddAttributeTypeURL($type)?>"><?=$formatter->getListIconElement()?> <?=$type->getAttributeTypeDisplayName()?></a></li>
            <? } ?>
        </ul>
    </div>

<?php } ?>

