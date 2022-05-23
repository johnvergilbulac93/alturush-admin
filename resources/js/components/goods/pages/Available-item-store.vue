<template>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-sm-4">
        <select
          class="form-control form-control-sm"
          v-model="filter.store"
          @change="getItems()"
        >
          <option value="">Choose Store</option>
          <option
            v-bind:value="{ id: store.bunit_code, text: store.business_unit }"
            v-for="(store, i) in stores"
            :key="i"
          >
            {{ store.business_unit }}
          </option>
        </select>
      </div>
      <!-- <div class="col-md-4 offset-md-4">
        <div class="float-right">
          <Button
            type="primary"
            :loading="loading"
            @click.prevent="generateBy"
            size="large"
          >
            <span v-if="!loading">Generate</span>
            <span v-else>Generating...</span>
          </Button>
        </div>
      </div> -->
    </div>

    <div class="row justify-content-center mt-2" v-if="filter.store != ''">
      <div class="col-sm-4">
        <!-- small box -->
        <div class="small-box bg-orange ">
          <div class="inner text-white">
            <center>
              <h5 class="lead py-2">AVAILABLE ITEMS</h5>
              <hr />
              <h1 class="py-2">{{ countItems }}</h1>
            </center>
            <p>{{ filter.store.text }}</p>
          </div>

          <!-- <a @click="showModalPrice" class="small-box-footer"
            >More info <i class="fas fa-arrow-circle-right"></i
          ></a> -->
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "Available-Item-Count-Per-Store",
  data() {
    return {
      stores: [],
      countItems: [],
      filter: {
        store: "",
        store_id: "",
      },
    };
  },
  methods: {
    getName() {},
    async getStores() {
      const { data } = await axios.get("api/stores");
      this.stores = data;
    },
    getItems(url = "api/item_count_available") {
      this.filter.store_id = this.filter.store.id;
      axios.get(url, { params: this.filter }).then((response) => {
        this.countItems = response.data.total;
      });
    },
  },
  mounted() {
    // this.getStores();
  },
};
</script>
