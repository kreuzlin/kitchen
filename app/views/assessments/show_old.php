<?php require APPROOT . '/views/inc/header.php'; ?>
  <?php flash('assessment_message'); ?>
  <?php //echo "<pre>", var_dump($data), "</pre>"; ?>
<div>
<div>
  <h1>Security Concept - <?php echo $data['assessment']->Assessment; ?></h1>
  <p class="lead">Author: <?php echo $data['assessment']->name; ?></p>
</div>
<?php $printedh2 = "" ?>
<?php $printedh3 = "" ?>
<?php $printedh4 = "" ?>
<?php foreach($data['chapters'] as $chapter) : ?>
<!-- switch does not allow for white spaces, therefore code is not properly formated -->
<?php switch ($chapter->Type):?>
<?php case 1:?>
<?php if ($printedh2 <> $chapter->Chapters_ID): ?>
<h2><?php echo $chapter->Chapter; ?></h2>
<?php $printedh2 = $chapter->Chapters_ID?>
<p><?php echo $chapter->Description; ?></p>
<?php endif; ?>
<?php if(isset($chapter->Requirement)): ?><h5>Requirement: <?php echo $chapter->Requirement; ?></h5><?php endif; ?>
<p class="font-italic"><?php echo $chapter->Description; ?></p>
<?php break ?>
<?php case 2: ?>
<?php if ($printedh3 <> $chapter->Chapters_ID): ?>
<h3><?php echo $chapter->Chapter; ?></h3>
<?php $printedh3 = $chapter->Chapters_ID?>
<p><?php echo $chapter->Description; ?></p>
<?php endif; ?>
<?php if(isset($chapter->Requirement)): ?><h5>Requirement: <?php echo $chapter->Requirement; ?></h5><?php endif; ?>
<p class="font-italic"><?php echo $chapter->Description; ?></p>
<?php break ?>
<?php case 3: ?>
<?php if ($printedh4 <> $chapter->Chapters_ID): ?>
<h4><?php echo $chapter->Chapter; ?></h4>
<?php $printedh4 = $chapter->Chapters_ID?>
<p><?php echo $chapter->Description; ?></p>
<?php endif; ?>
<?php if(isset($chapter->Requirement)): ?><h5>Requirement: <?php echo $chapter->Requirement; ?></h5><?php endif; ?>
<p class="font-italic"><?php echo $chapter->Description; ?></p>
<?php endswitch ?>

<?php endforeach; ?>  


<?php require APPROOT . '/views/inc/footer.php'; ?>