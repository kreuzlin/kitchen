<?php require APPROOT . '/views/inc/header.php'; ?>
  <?php flash('assessment_message'); ?>
  <?php //echo "<pre>", var_dump($data['concept']), "</pre>"; ?>
<div>
<div class="container">
  <div class="btn-toolbar">
    <div class="btn-group mr-1">
      <button class="btn btn-secondary btn-sm" type="button" data-toggle="collapse" data-target="#collapseExplainations" aria-expanded="false" aria-controls="collapseExplainations">
        Hide / unhide explainations
      </button>
    </div>
    <div class="btn-group mr-1">
      <button class="btn btn-secondary btn-sm" type="button" data-toggle="collapse" data-target="#collapseStatusControl" aria-expanded="false" aria-controls="collapseExplainations">
        Hide / unhide status control
      </button>
    </div><div class="btn-group mr-1">
    <a class="btn btn-secondary btn-sm" href="<?php echo URLROOT . '/assessments/edit/' . $data['assessment']->ID; ?>" role="button">Edit Exposures</a>
  </div>
</div>
<div>
  <h1>Security Concept - <?php echo $data['assessment']->Assessment; ?></h1>
  <p class="lead">Author: <?php echo $data['assessment']->name; ?></p>
</div>

<?php foreach($data['concept'] as $concept_item) : ?>
<?php switch ($concept_item['format']):?>
<?php case "h1":?>
<h2><?php echo $concept_item['text']?></h2>
<?php break ?>
<?php case "h2":?>
<h3><?php echo $concept_item['text']?></h3>
<?php break ?>
<?php case "h3":?>
<h4><?php echo $concept_item['text']?></h4>
<?php break ?>
<?php case "chpaterDescription":?>
<div class="collapse" id="collapseExplainations">
<div class="card card-body">
<p class="text-black-50"><?php echo $concept_item['text']?></p>
</div>
</div>
<?php break ?>
<?php case "requirement":?>
<h5>Requirement <?php echo $concept_item['id']?>: <?php echo $concept_item['text']?></h5>
<?php break ?>
<?php case "requirementDescription":?>
<div class="collapse" id="collapseStatusControl">
<div class="btn-group btn-group-toggle" data-toggle="buttons">
<label class="btn btn-secondary btn-sm active"><input type="radio" name="status[<?php echo $concept_item['id']?>]" id="option1" value="open" autocomplete="off" checked> open</label>
<label class="btn btn-secondary btn-sm"><input type="radio" name="status[<?php echo $concept_item['id']?>]" id="option2" value="n/a" autocomplete="off"> n/a</label>
<label class="btn btn-secondary btn-sm"><input type="radio" name="status[<?php echo $concept_item['id']?>]" id="option3" value="ok" autocomplete="off"> ok</label>
<label class="btn btn-secondary btn-sm"><input type="radio" name="status[<?php echo $concept_item['id']?>]" id="option4" value="gap" autocomplete="off"> gap</label>
</div>
</div>
<p class="font-italic"><?php echo $concept_item['text']?></p>
<div class="form-group">
<label for="textarea<?php echo $concept_item['id']?>">Why is this requirement not applicable: <a href="#">(examples)</a></label>
<textarea class="form-control" id="textarea<?php echo $concept_item['id']?>" name="answers[<?php echo $concept_item['id']?>]" rows="3"></textarea>
<button type="button" id="<?php echo $concept_item['id']?>" name="btnUpd" class="btn btn-primary btn-sm" onclick="updConcept(document.getElementById('textarea<?php echo $concept_item['id']?>').value,this.id)">Update</button>
</div>
<?php break ?>
<?php default:?>
<p>error in switch case: <?php echo $data['format']?></p>
<?php exit ?>
<?php endswitch ?>
<?php endforeach; ?>

<?php require APPROOT . '/views/inc/footer.php'; ?>


