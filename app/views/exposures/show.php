<?php require APPROOT . '/views/inc/header.php'; ?>
  <pre> <?php //echo var_dump($data); ?> </pre>
  <div class="pt-4">
      <h1 class><?php echo $data['exposure']->exposure; ?></h1>
      <p><?php echo $data['exposure']->description; ?></p>

      <form>
        <div class="form-group">
          <label for="Reference">category</label>
          <input type="text" class="form-control"  id="category" value="<?php echo $data['exposure']->category; ?>" readonly>
        </div>
      </form>
  </div>

  <div class="container">
    <form action="<?php echo URLROOT; ?>/exposures/relation/<?php echo $data['exposure']->id; ?>" method="post"> 
      <div class="row">
        <div class="col-sm">
        <h4>releated requirements:</h4>
        <select class="custom-select" multiple size="10" name="id_remove[]">
          <?php foreach($data['relatedRequirements'] as $relatedRequirement) : ?>
            <option value="<?php echo $relatedRequirement->id; ?>"><?php echo $relatedRequirement->requirement; ?></option>
          <?php endforeach; ?> 
        </select>
        </div>
        <div class="col-sm text-center align-self-center">
          <div class="btn-group-vertical" role="group" aria-label="Basic example">
            <button name="action" value="add" type="submit" class="btn btn-secondary"><-</button>
            <button name="action" value="remove" type="submit" class="btn btn-secondary">-></button>
          </div>
        </div>
        <div class="col-sm">
        <h4>unreleated requirements:</h4>
        <select class="custom-select" multiple size="10" name="id_add[]">
          <?php foreach($data['notRelatedRequirements'] as $notRelatedRequirement) : ?>
            <option value="<?php echo $notRelatedRequirement->id; ?>"><?php echo $notRelatedRequirement->requirement; ?></option>
          <?php endforeach; ?> 
        </select>
        </div>
      </div>
    </form>
  </div>

<?php require APPROOT . '/views/inc/footer.php'; ?>