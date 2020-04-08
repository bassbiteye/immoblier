<template>
  <div>
    <!-- Info boxes -->
    <div class="row">
      <div class="col-12 col-sm-6 col-md-3">
        <div class="info-box">
          <span class="info-box-icon bg-info elevation-1">
            <i class="fas fa-building"></i>
          </span>

          <div class="info-box-content">
            <span class="info-box-text">Biens</span>
            <span class="info-box-number" v-if="bien">{{bien}}</span>
          </div>
          <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
      </div>
      <!-- /.col -->
      <div class="col-12 col-sm-6 col-md-3">
        <div class="info-box mb-3">
          <span class="info-box-icon bg-danger elevation-1">
            <i class="fas fa-user"></i>
          </span>

          <div class="info-box-content">
            <span class="info-box-text">Clients</span>
            <span class="info-box-number" v-if="client">{{client}}</span>
          </div>
          <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
      </div>
      <!-- /.col -->

      <!-- fix for small devices only -->
      <div class="clearfix hidden-md-up"></div>

      <div class="col-12 col-sm-6 col-md-3">
        <div class="info-box mb-3">
          <span class="info-box-icon bg-success elevation-1">
            <i class="fas fa-chart-pie"></i>
          </span>

          <div class="info-box-content">
            <span class="info-box-text">Bailleurs</span>
            <span class="info-box-number" v-if="bailleur">{{bailleur}}</span>
          </div>
          <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
      </div>
      <!-- /.col -->
      <div class="col-12 col-sm-6 col-md-3">
        <div class="info-box mb-3">
          <span class="info-box-icon bg-warning elevation-1">
            <i class="fas fa-users"></i>
          </span>

          <div class="info-box-content">
            <span class="info-box-text">Utilsateurs</span>
            <span class="info-box-number" v-if="user">{{user}}</span>
          </div>
          <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
  </div>
</template>

<script>
import notFoundComponentVue from "./notFoundComponent.vue";

export default {
  components: {
    "not-found": notFoundComponentVue
  },
  mounted() {
    this.countuser();
    this.countclients();
    this.countbiens();
    this.countbailleurs();
  },

  data() {
    return {
      user: "",
      bailleur: "",
      client: "",
      bien: ""
    };
  },
  methods: {
    countuser() {
      axios.get("api/countuser").then(response => {
        this.user = response.data;
      });
    },
    countclients() {
      axios.get("api/countclients").then(response => {
        this.client = response.data;
      });
    },
    countbailleurs() {
      axios.get("api/countbailleurs").then(response => {
        this.bailleur = response.data;
      });
    },
    countbiens() {
      axios.get("api/countbiens").then(response => {
        this.bien = response.data;
      });
    }
  }
};
</script>
