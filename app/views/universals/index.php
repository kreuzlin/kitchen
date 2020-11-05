<?php require APPROOT . '/views/inc/header.php'; ?>
  <?php flash('universal_message'); ?>
<div>
<div>
  <h1>Table Name</h1>
</div>
<div>
<pre> <?php //var_dump($data['colums']); ?> </pre>
<form action="<?php echo URLROOT; ?>/universals/delete/" method="post">
    <table id="dtBasicTab" class="table">
      <thead><tr>
        <th class="th-sm">#</th>
        <th class="th-sm">...</th>
        <?php foreach($data['columsWithoutID'] as $colum) : ?>
          <th class="th-sm"><?php echo $colum ?></th>
        <?php endforeach; ?> 
      </tr></thead>
      <tbody>
      <?php foreach($data['entries'] as $entry) : ?>
        <tr>
          <td><input type="checkbox" name="id[]" value="<?php echo $entry->ID; ?>"></td>
          <td><a href="<?php echo URLROOT . '/requirements/edit/' . $entry->ID; ?>">edit</a></td>
          <td><a href="<?php echo URLROOT . '/requirements/show/' . $entry->ID; ?>"><?php echo $entry->Requirement; ?></a></td>
          <?php foreach($data['columsWithoutID'] as $colum) : ?>
            <td><?php echo $entry->Description; ?></td>
          <?php endforeach; ?> 
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