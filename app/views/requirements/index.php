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
          <td><input type="checkbox" name="id[]" value="<?php echo $requirement->ID; ?>"></td>
          <td><a href="<?php echo URLROOT . '/requirements/edit/' . $requirement->ID; ?>">edit</a></td>
          <td><a href="<?php echo URLROOT . '/requirements/show/' . $requirement->ID; ?>"><?php echo $requirement->Requirement; ?></a></td>
          <td><?php echo $requirement->Description; ?></td>
          <td><?php echo $requirement->Chapter; ?></td>
          <td><?php echo $requirement->Area; ?></td>
          <td><?php echo $requirement->Standard; ?></td>
          <td><?php echo $requirement->Examples; ?></td>
          <td><?php echo $requirement->Relevant; ?></td>
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