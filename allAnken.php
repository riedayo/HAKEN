<section id="main">
  <table>
    <thead>
      <tr>
        <th>日付</th>
        <th>最寄り駅</th>
        <th>店名</th>
        <th>時給</th>
        <th>時間</th>
        <th></th>
      </tr>
    </thead>

      <?php

      foreach ($stmt as $key => $val):
       ?>
    <tbody>
      <td><?php echo $val['anken_date']; ?></td>
      <td><?php echo $val['station']; ?></td>
      <td><?php echo $val['tenpo_name']; ?></td>
      <td><?php echo $val['salary']; ?>円</td>
      <td><?php echo $val['start_time']; ?></td>
      <td><a href="">詳細</a></td>

      </tbody>
      <?php
      endforeach;
      ?>



    <!-- <tbody>
      <td>2019.5.5(金)</td>
      <td>恵比寿</td>
      <td>スピッツ</td>
      <td>3,500円</td>
      <td>21:00</td>
      <td>詳細</td>
    </tbody>
    <tbody>
      <td>2019.5.5(金)</td>
      <td>恵比寿</td>
      <td>スピッツ</td>
      <td>3,500円</td>
      <td>21:00</td>
      <td>詳細</td>
    </tbody>
    <tbody>
      <td>2019.5.5(金)</td>
      <td>恵比寿</td>
      <td>スピッツ</td>
      <td>3,500円</td>
      <td>21:00</td>
      <td>詳細</td>
    </tbody>
    <tbody>
      <td>2019.5.5(金)</td>
      <td>恵比寿</td>
      <td>スピッツ</td>
      <td>3,500円</td>
      <td>21:00</td>
      <td>詳細</td>
    </tbody>
    <tbody>
      <td>2019.5.5(金)</td>
      <td>恵比寿</td>
      <td>スピッツ</td>
      <td>3,500円</td>
      <td>21:00</td>
      <td>詳細</td>
    </tbody>
    <tbody>
      <td>2019.5.5(金)</td>
      <td>恵比寿</td>
      <td>スピッツ</td>
      <td>3,500円</td>
      <td>21:00</td>
      <td>詳細</td>
    </tbody>
    <tbody>
      <td>2019.5.5(金)</td>
      <td>恵比寿</td>
      <td>スピッツ</td>
      <td>3,500円</td>
      <td>21:00</td>
      <td>詳細</td>
    </tbody> -->

  </table>

  <!-- <div class="pagination">
            <ul class="pagination-list">
              <li class="list-item"><a href="">&lt;</a></li>
              <li class="list-item"><a href="">1</a></li>
              <li class="list-item"><a href="">2</a></li>
              <li class="list-item active"><a href="">3</a></li>
              <li class="list-item"><a href="">4</a></li>
              <li class="list-item"><a href="">5</a></li>
              <li class="list-item"><a href="">&gt;</a></li>
            </ul>
  </div> -->

</section>
