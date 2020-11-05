<?php require APPROOT . '/views/inc/header.php'; ?>
  <?php flash('exposure_message'); ?>
  <?php //echo "<pre>", var_dump($data['requirements']), "</pre>"; ?>
<div>
<div>
  <h1>Exposures</h1>
</div>
<div>
<form action="<?php echo URLROOT; ?>/exposures/delete/" method="post">
    <table id="dtBasicTab" class="table">
      <thead><tr>
        <th class="th-sm">#</th>
        <th class="th-sm">...</th>
        <th class="th-sm">Exposure</th>
        <th class="th-sm">Description</th>
        <th class="th-sm">Category</th>
      </tr></thead>
      <tbody>
      <!-- https://www.tutorialrepublic.com/snippets/preview.php?topic=bootstrap&file=crud-data-table-for-database-with-modal-form -->
      <?php foreach($data['exposures'] as $exposure) : ?>
        <tr>
          <td><input type="checkbox" name="id[]" value="<?php echo $exposure->ID; ?>"></td>
          <td><a href="<?php echo URLROOT . '/exposures/edit/' . $exposure->ID; ?>">edit</a></td>
          <td><a href="<?php echo URLROOT . '/exposures/show/' . $exposure->ID; ?>"><?php echo $exposure->Exposure; ?></a></td>
          <td><?php echo $exposure->Description; ?></td>
          <td><?php echo $exposure->Category; ?></td>
        </tr>
      <?php endforeach; ?>         
      </tbody>
    </table>
    <div class="btn-group btn-group-sm" role="group" aria-label="Basic">
      <p><a href="<?php echo URLROOT . '/exposures/add'; ?>" class="btn btn-primary" role="button">add</a></p>
      <input type="submit" class="btn btn-primary" value="delete">
    </div>
  </form>
<?php require APPROOT . '/views/inc/footer.php'; ?>