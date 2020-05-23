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
    <div class="row">
      <!-- ============================================================== -->
      <!-- sales  -->
      <!-- ============================================================== -->
      <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
        <div class="card border-3 border-top border-top-primary">
          <div class="card-body">
            <h5 class="text-muted">Biens</h5>
            <div class="metric-value d-inline-block">
              <h1 class="mb-1" v-if="bien">{{bien}}</h1>
            </div>
            <div class="metric-label d-inline-block float-right text-success font-weight-bold">
              <span class="icon-circle-small icon-box-xs text-success bg-success-light">
                <i class="fa fa-fw fa-arrow-up"></i>
              </span>
            </div>
          </div>
        </div>
      </div>
      <!-- ============================================================== -->
      <!-- end sales  -->
      <!-- ============================================================== -->
      <!-- ============================================================== -->
      <!-- new customer  -->
      <!-- ============================================================== -->
      <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
        <div class="card border-3 border-top border-top-primary">
          <div class="card-body">
            <h5 class="text-muted">Clients</h5>
            <div class="metric-value d-inline-block">
              <h1 class="mb-1" v-if="client">{{client}}</h1>
            </div>
            <div class="metric-label d-inline-block float-right text-success font-weight-bold">
              <span class="icon-circle-small icon-box-xs text-success bg-success-light">
                <i class="fa fa-fw fa-arrow-up"></i>
              </span>
            </div>
          </div>
        </div>
      </div>
      <!-- ============================================================== -->
      <!-- end new customer  -->
      <!-- ============================================================== -->
      <!-- ============================================================== -->
      <!-- visitor  -->
      <!-- ============================================================== -->
      <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
        <div class="card border-3 border-top border-top-primary">
          <div class="card-body">
            <h5 class="text-muted">Bailleurs</h5>
            <div class="metric-value d-inline-block">
              <h1 class="mb-1" v-if="bailleur">{{bailleur}}</h1>
            </div>
            <div class="metric-label d-inline-block float-right text-success font-weight-bold">
              <span class="icon-circle-small icon-box-xs text-success bg-success-light">
                <i class="fa fa-fw fa-arrow-up"></i>
              </span>
              <span class="ml-1"></span>
            </div>
          </div>
        </div>
      </div>
      <!-- ============================================================== -->
      <!-- end visitor  -->
      <!-- ============================================================== -->
      <!-- ============================================================== -->
      <!-- total orders  -->
      <!-- ============================================================== -->
      <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
        <div class="card border-3 border-top border-top-primary">
          <div class="card-body">
            <h5 class="text-muted">Utilsateurs</h5>
            <div class="metric-value d-inline-block">
              <h1 class="mb-1" v-if="user">{{user}}</h1>
            </div>
            <div class="metric-label d-inline-block float-right text-danger font-weight-bold">
              <span
                class="icon-circle-small icon-box-xs text-danger bg-danger-light bg-danger-light"
              >
                <i class="fa fa-fw fa-arrow-down"></i>
              </span>
              <span class="ml-1">4%</span>
            </div>
          </div>
        </div>
      </div>
      <!-- ============================================================== -->
      <!-- end total orders  -->
      <!-- ============================================================== -->
    </div>
     <div class="row">
      <!-- ============================================================== -->
      <!-- sales  -->
      <!-- ============================================================== -->
      <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
        <div class="card border-3 border-top border-top-primary">
          <div class="card-body">
            <h5 class="text-muted">Sales</h5>
            <div class="metric-value d-inline-block">
              <h1 class="mb-1">$12099</h1>
            </div>
            <div class="metric-label d-inline-block float-right text-success font-weight-bold">
              <span class="icon-circle-small icon-box-xs text-success bg-success-light">
                <i class="fa fa-fw fa-arrow-up"></i>
              </span>
              <span class="ml-1">5.86%</span>
            </div>
          </div>
        </div>
      </div>
      <!-- ============================================================== -->
      <!-- end sales  -->
      <!-- ============================================================== -->
      <!-- ============================================================== -->
      <!-- new customer  -->
      <!-- ============================================================== -->
      <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
        <div class="card border-3 border-top border-top-primary">
          <div class="card-body">
            <h5 class="text-muted">New Customer</h5>
            <div class="metric-value d-inline-block">
              <h1 class="mb-1">1245</h1>
            </div>
            <div class="metric-label d-inline-block float-right text-success font-weight-bold">
              <span class="icon-circle-small icon-box-xs text-success bg-success-light">
                <i class="fa fa-fw fa-arrow-up"></i>
              </span>
              <span class="ml-1">10%</span>
            </div>
          </div>
        </div>
      </div>
      <!-- ============================================================== -->
      <!-- end new customer  -->
      <!-- ============================================================== -->
      <!-- ============================================================== -->
      <!-- visitor  -->
      <!-- ============================================================== -->
      <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
        <div class="card border-3 border-top border-top-primary">
          <div class="card-body">
            <h5 class="text-muted">Visitor</h5>
            <div class="metric-value d-inline-block">
              <h1 class="mb-1">13000</h1>
            </div>
            <div class="metric-label d-inline-block float-right text-success font-weight-bold">
              <span class="icon-circle-small icon-box-xs text-success bg-success-light">
                <i class="fa fa-fw fa-arrow-up"></i>
              </span>
              <span class="ml-1">5%</span>
            </div>
          </div>
        </div>
      </div>
      <!-- ============================================================== -->
      <!-- end visitor  -->
      <!-- ============================================================== -->
      <!-- ============================================================== -->
      <!-- total orders  -->
      <!-- ============================================================== -->
      <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
        <div class="card border-3 border-top border-top-primary">
          <div class="card-body">
            <h5 class="text-muted">Total Orders</h5>
            <div class="metric-value d-inline-block">
              <h1 class="mb-1">1340</h1>
            </div>
            <div class="metric-label d-inline-block float-right text-danger font-weight-bold">
              <span
                class="icon-circle-small icon-box-xs text-danger bg-danger-light bg-danger-light"
              >
                <i class="fa fa-fw fa-arrow-down"></i>
              </span>
              <span class="ml-1">4%</span>
            </div>
          </div>
        </div>
      </div>
      <!-- ============================================================== -->
      <!-- end total orders  -->
      <!-- ============================================================== -->
    </div>
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
    this.soldebailleur();
  },

  data() {
    return {
      user: "",
      bailleur: "",
      client: "",
      bien: "",
      soldeBailleur:""
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
    },
    soldebailleur(){
          axios.get("api/soldebailleur").then(response => {
        this.soldeBailleur = response.data;
      });
    }
  }
};
</script>
