<?php require APPROOT . '/views/inc/header.php'; ?>
  <?php flash('requirement_message'); ?>
  <?php //echo "<pre>", var_dump($data['risks']), "</pre>"; ?>
<div>
<div>
  <h1>Risks</h1>
</div>
<div>
<form action="<?php echo URLROOT; ?>/risks/delete/" method="post">
    <table id="dtBasicTab" class="table">
      <thead><tr>
        <th class="th-sm">#</th>
        <th class="th-sm">...</th>
        <th class="th-sm">Risk</th>
        <th class="th-sm">Description</th>
        <th class="th-sm">Reference</th>
      </tr></thead>
      <tbody>
      <!-- https://www.tutorialrepublic.com/snippets/preview.php?topic=bootstrap&file=crud-data-table-for-database-with-modal-form -->
      <?php foreach($data['risks'] as $risk) : ?>
        <tr>
          <td><input type="checkbox" name="id[]" value="<?php echo $risk->id; ?>"></td>
          <td><a href="<?php echo URLROOT . '/risks/edit/' . $risk->id; ?>">edit</a></td>
          <td><a href="<?php echo URLROOT . '/risks/show/' . $risk->id; ?>"><?php echo $risk->risk; ?></a></td>
          <td><?php echo $risk->description; ?></td>
          <td><?php echo $risk->reference; ?></td>
        </tr>
      <?php endforeach; ?>         
      </tbody>
    </table>
    <div class="btn-group btn-group-sm" role="group" aria-label="Basic">
      <p><a href="<?php echo URLROOT . '/risks/add'; ?>" class="btn btn-primary" role="button">add</a></p>
      <input type="submit" class="btn btn-primary" value="delete">
    </div>
  </form>
<?php require APPROOT . '/views/inc/footer.php'; ?>