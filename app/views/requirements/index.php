<?php require APPROOT . '/views/inc/header.php'; ?>
  <?php flash('requirement_message'); ?>
  <?php //echo "<pre>", var_dump($data['requirements']), "</pre>"; ?>
<div>
<div>
  <h1>Requirements</h1>
</div>
<div>
<form action="<?php echo URLROOT; ?>/requirements/delete/" method="post">
    <table id="dtBasicTab" class="table">
      <thead><tr>
        <th class="th-sm">#</th>
        <th class="th-sm">...</th>
        <th class="th-sm">Requirement</th>
        <th class="th-sm">Description</th>
        <th class="th-sm">Chapter</th>
        <th class="th-sm">Area</th>
        <th class="th-sm">Standard</th>
        <th class="th-sm">Examples</th>
        <th class="th-sm">Relevant</th>
      </tr></thead>
      <tbody>
      <!-- https://www.tutorialrepublic.com/snippets/preview.php?topic=bootstrap&file=crud-data-table-for-database-with-modal-form -->
      <?php foreach($data['requirements'] as $requirement) : ?>
        <tr>
          <td><input type="checkbox" name="id[]" value="<?php echo $requirement->id; ?>"></td>
          <td><a href="<?php echo URLROOT . '/requirements/edit/' . $requirement->id; ?>">edit</a></td>
          <td><a href="<?php echo URLROOT . '/requirements/show/' . $requirement->id; ?>"><?php echo $requirement->requirement; ?></a></td>
          <td><?php echo $requirement->description; ?></td>
          <td><?php echo $requirement->chapter; ?></td>
          <td><?php echo $requirement->area; ?></td>
          <td><?php echo $requirement->standard; ?></td>
          <td><?php echo $requirement->examples; ?></td>
          <td><?php echo $requirement->relevant; ?></td>
        </tr>
      <?php endforeach; ?>         
      </tbody>
    </table>
    <div class="btn-group btn-group-sm" role="group" aria-label="Basic">
      <p><a href="<?php echo URLROOT . '/requirements/add'; ?>" class="btn btn-primary" role="button">add</a></p>
      <input type="submit" class="btn btn-primary" value="delete">
    </div>
  </form>
<?php require APPROOT . '/views/inc/footer.php'; ?>