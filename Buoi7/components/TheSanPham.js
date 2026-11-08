// Component the-san-pham
const TheSanPham = {
  props: {
    ten: { type: String, required: true },
    gia: { type: Number, required: true },
    anh: { type: String, default: 'lena.png' },
    mota: { type: String, default: 'Chưa có mô tả' },
    tonkho: { type: Number, default: 0 }
  },
  data() {
    return {
      showMota: false
    };
  },
  template: `
    <div class="card">
      <img :src="anh" :alt="ten">
      <h3>{{ ten }}</h3>
      <p class="gia">{{ gia.toLocaleString() }} đ</p>
      <p v-if="tonkho > 0">Còn {{ tonkho }} sản phẩm</p>
      <p v-else class="het">Hết hàng</p>
      <p class="mota" v-if="showMota">{{ mota }}</p>
      <button class="xem" @click="showMota = !showMota">Xem mô tả</button>
      <button :disabled="tonkho === 0">Mua</button>
    </div>
  `
};
