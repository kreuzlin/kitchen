<?php require APPROOT . '/views/inc/header.php'; ?>
  <pre> <?php //echo var_dump($data); ?> </pre>
  <div class="pt-4">
      <h1 class><?php echo $data['exposure']->Exposure; ?></h1>
      <p><?php echo $data['exposure']->Description; ?></p>

      <form>
        <div class="form-group">
          <label for="Reference">Category</label>
          <input type="text" class="form-control"  id="Category" value="<?php echo $data['exposure']->Category; ?>" readonly>
        </div>
      </form>
  </div>

  <div class="container">
    <form action="<?php echo URLROOT; ?>/exposures/relation/<?php echo $data['exposure']->ID; ?>" method="post"> 
      <div class="row">
        <div class="col-sm">
        <h4>releated requirements:</h4>
        <select class="custom-select" multiple size="10" name="id_remove[]">
          <?php foreach($data['relatedRequirements'] as $relatedRequirement) : ?>
            <option value="<?php echo $relatedRequirement->ID; ?>"><?php echo $relatedRequirement->Requirement; ?></option>
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
            <option value="<?php echo $notRelatedRequirement->ID; ?>"><?php echo $notRelatedRequirement->Requirement; ?></option>
          <?php endforeach; ?> 
        </select>
        </div>
      </div>
    </form>
  </div>

<?php require APPROOT . '/views/inc/footer.php'; ?>