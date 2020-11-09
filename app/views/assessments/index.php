<?php require APPROOT . '/views/inc/header.php'; ?>
  <?php flash('assessment_message'); ?>
  <?php //echo "<pre>", var_dump($data), "</pre>"; ?>
<div>
<div>
  <h1>Assessments</h1>
</div>
<div>
<form action="<?php echo URLROOT; ?>/assessments/delete/" method="post">
    <table id="dtBasicTab" class="table">
      <thead><tr>
        <th class="th-sm">#</th>
        <th class="th-sm">...</th>
        <th class="th-sm">Assessment</th>
        <th class="th-sm">Creation</th>
        <th class="th-sm">Status</th>
        <th class="th-sm">Owner</th>
      </tr></thead>
      <tbody>
      <!-- https://www.tutorialrepublic.com/snippets/preview.php?topic=bootstrap&file=crud-data-table-for-database-with-modal-form -->
      <?php foreach($data['assessments'] as $assessment) : ?>
        <tr>
          <td><input type="checkbox" name="id[]" value="<?php echo $assessment->assessments_id; ?>"></td>
          <td><a href="<?php echo URLROOT . '/assessments/edit/' . $assessment->assessments_id; ?>">edit</a></td>
          <td><a href="<?php echo URLROOT . '/assessments/show/' . $assessment->assessments_id; ?>"><?php echo $assessment->assessment; ?></a></td>
          <td><?php echo $assessment->creation; ?></td>
          <td><?php echo $assessment->status; ?></td>
          <td><?php echo $assessment->name; ?></td>
        </tr>
      <?php endforeach; ?>         
      </tbody>
    </table>
    <div class="btn-group btn-group-sm" role="group" aria-label="Basic">
      <p><a href="<?php echo URLROOT . '/assessments/add'; ?>" class="btn btn-primary" role="button">new</a></p>
      <input type="submit" class="btn btn-primary" value="delete">
    </div>
  </form>
<?php require APPROOT . '/views/inc/footer.php'; ?>