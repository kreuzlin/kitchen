<?php require APPROOT . '/views/inc/header.php'; ?>
  <?php flash('assessment_message'); ?>
  <?php //echo "<pre>", var_dump($data['concept']), "</pre>"; ?>
<div>
<input type="hidden" id="aid" name="aid" value="<?php echo $data['assessment']->assessments_id; ?>">
<?php $textOpen = 'How is this requirement met: '; ?>
<?php $textNA = 'Why is this requirement not applicable: '; ?>
<?php $textOK = 'This is how this requirement is met: '; ?>
<?php $textGap = 'What of the requirement is met, what is the gap, why is there a gap: '; ?>
<p id="textOpen" hidden><?php echo $textOpen ?></p>
<p id="textNA" hidden><?php echo $textNA ?></p>
<p id="textOK" hidden><?php echo $textOK ?></p>
<p id="textGap" hidden><?php echo $textGap ?></p>
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
    <a class="btn btn-secondary btn-sm" href="<?php echo URLROOT . '/assessments/edit/' . $data['assessment']->assessments_id; ?>" role="button">Edit Exposures</a>
  </div>
</div>
<div>
  <h1>Security Concept - <?php echo $data['assessment']->assessment; ?></h1>
  <p class="lead">Author: <?php echo $data['assessment']->name; ?></p>
</div>

<?php foreach($data['concept'] as $concept_item) : ?>
<?php switch ($concept_item['format']):?>
<?php case "h1":?>
<h2><?php echo $concept_item['text']?></h2>
<?php break ?>
<?php case "h2":?>
<h3><?php echo $concept_item['text']?></h3>
<?php if ($concept_item['text'] == 'Assets'): ?>
<img class="mx-auto d-block" src="<?php echo URLROOT . '/public/diagram.jpg'?>" alt="diagram">
<?php endif; ?>
<?php if ($concept_item['text'] == 'Known constraints and limiatations'): ?>
<ul>
<?php foreach($data['residualRisks'] as $risk_item) : ?>
<li><?php echo 'The <a href="#'.$risk_item->requirement.'">gap</a> in the ' . $risk_item->requirement . ' requirement leads to some exposure with regard to ' . $risk_item->risk ?></li>
<?php endforeach; ?>
</ul>
<?php endif; ?>
<?php if ($concept_item['text'] == 'Key risks and controls'): ?>
<canvas id="radarChart"></canvas>
<?php endif; ?>
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
<h5 id="<?php echo $concept_item['text']?>">Requirement <?php echo $concept_item['id']?>: <?php echo $concept_item['text']?></h5>
<?php break ?>
<?php case "requirementDescription":?>
<div class="collapse" id="collapseStatusControl">
<div class="btn-group btn-group-toggle" data-toggle="buttons">
<?php if ($concept_item['status'] == 'open'): ?>
<label class="btn btn-secondary btn-sm active"><input type="radio" name="status[<?php echo $concept_item['id']?>]" id="option1" value="open" autocomplete="off" checked> open</label>
<?php else: ?>
<label class="btn btn-secondary btn-sm"><input type="radio" name="status[<?php echo $concept_item['id']?>]" id="option1" value="open" autocomplete="off"> open</label>
<?php endif; ?>
<?php if ($concept_item['status'] == 'n/a'): ?>
<label class="btn btn-secondary btn-sm active"><input type="radio" name="status[<?php echo $concept_item['id']?>]" id="option2" value="n/a" autocomplete="off" checked> n/a</label>
<?php else: ?>
<label class="btn btn-secondary btn-sm"><input type="radio" name="status[<?php echo $concept_item['id']?>]" id="option2" value="n/a" autocomplete="off"> n/a</label>
<?php endif; ?>
<?php if ($concept_item['status'] == 'ok'): ?>
<label class="btn btn-secondary btn-sm active"><input type="radio" name="status[<?php echo $concept_item['id']?>]" id="option3" value="ok" autocomplete="off" checked> ok</label>
<?php else: ?>
<label class="btn btn-secondary btn-sm"><input type="radio" name="status[<?php echo $concept_item['id']?>]" id="option3" value="ok" autocomplete="off"> ok</label>
<?php endif; ?>
<?php if ($concept_item['status'] == 'gap'): ?>
<label class="btn btn-secondary btn-sm active"><input type="radio" name="status[<?php echo $concept_item['id']?>]" id="option4" value="gap" autocomplete="off" checked> gap</label>
<?php else: ?>
<label class="btn btn-secondary btn-sm"><input type="radio" name="status[<?php echo $concept_item['id']?>]" id="option4" value="gap" autocomplete="off"> gap</label>
<?php endif; ?>
</div>
</div>
<p class="font-italic"><?php echo $concept_item['text']?></p>
<div class="form-group">
<?php switch ($concept_item['status']):?>
<?php case "n/a":?>
<label for="textarea<?php echo $concept_item['id']?>"><?php echo $textNA ?><a href="#">(examples)</a></label>
<?php break ?>
<?php case "ok":?>
<label for="textarea<?php echo $concept_item['id']?>"><?php echo $textOK ?><a href="#">(examples)</a></label>
<?php break ?>
<?php case "gap":?>
<label for="textarea<?php echo $concept_item['id']?>"><?php echo $textGap ?><a href="#">(examples)</a></label>
<?php break ?>
<?php default:?>
<label for="textarea<?php echo $concept_item['id']?>"><?php echo $textOpen ?></label>
<?php endswitch ?>
<textarea class="form-control" id="textarea<?php echo $concept_item['id']?>" name="answers[<?php echo $concept_item['id']?>]" rows="3"><?php echo $concept_item['content']?></textarea>
<button type="button" id="<?php echo $concept_item['id']?>" name="btnUpd" class="btn btn-primary btn-sm" onclick="updConcept(document.getElementById('textarea<?php echo $concept_item['id']?>').value,this.id)">Update</button>
</div>
<?php break ?>
<?php default:?>
<p>error in switch case: <?php echo $data['format']?></p>
<?php exit ?>
<?php endswitch ?>
<?php endforeach; ?>



<?php require APPROOT . '/views/inc/footer.php'; ?>


