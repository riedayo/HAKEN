<section id="sidebar" style="height:250px;">
        <form class="search-bar" action="index.php" method="get">


        <label class="search">
                <h1 class="title">業種</h1>
                <div class="selectbox">
                  <span class="icn-select"></span>
                  <select class="sidebar-select" name="c_id">
                  <option value="0" <?php if(getFormData('c_id',true) == 0 ){ echo 'selected';} ?>>選択してください</option>
                  <?php 
                  foreach($dbCategoryData as $key => $val){
                  ?>
                  <option value="<?php echo $val['id'] ?>" <?php if(getFormData('c_id',true) == $val['id'] ){echo 'selected'; } ?>>
                    <?php echo $val['category_name']; ?>
                  </option>
                  <?php
                  }
                  ?>
                  </select>
                </div>

              </label>
          
          <label class="search">
            <form  method="get">
                <h1 class="title">時給</h1>
                <div class="selectbox">
                  <span class="icn-select"></span>
                  <select class="sidebar-select" name="sort">
                    <option value="0" <?php if(getFormData('sort',true) == 0 ){ echo 'selected'; } ?>>選択してください</option>
                    <option value="1" <?php if(getFormData('sort',true) == 1 ){ echo 'selected'; } ?>>時給が安い順</option>
                    <option value="2" <?php if(getFormData('sort',true) == 2 ){ echo 'selected'; } ?>>時給が高い順</option>
                  </select>
                </div>

              </label>

              
              
              <input type="submit" name="" value="検索">
        </form>

      </section>
