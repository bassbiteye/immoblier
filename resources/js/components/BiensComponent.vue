<template>
 
  <div class="conteiner">
    <!-- Button trigger modal-->

    <!-- Modal: modalbien -->
    <div
      class="modal fade"
      id="modalCart"
      tabindex="-1"
      role="dialog"
      aria-labelledby="exampleModalLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <!--Header-->
          <div class="modal-header">
            <h4 class="modal-title" id="myModalLabel">Bien</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <!--Body-->
          <div class="modal-body">
            <table class="table table-hover">
              <tbody>
                <tr>
                  <th scope="row">Propriétaire</th>
                  <td>{{detailBien.name}}</td>
                </tr>
                <tr>
                  <th scope="row">Type</th>
                  <td>{{detailBien.libelle}}</td>
                </tr>
                <tr>
                  <th scope="row">Valeur</th>
                  <td>{{detailBien.prix}}</td>
                </tr>
                <tr>
                  <th scope="row">Adresse</th>
                  <td>{{detailBien.adresse}}</td>
                </tr>
                <tr class="total">
                  <th scope="row">Etat</th>
                  <td>{{detailBien.libelleE}}</td>
                </tr>
                <tr class="total">
                  <th scope="row">Description</th>
                  <td>{{detailBien.details}}</td>
                </tr>
                  <tr class="total">
                  <th scope="row">solde</th>
                  <td>{{detailBien.solde}}</td>
                </tr>
              </tbody>
            </table>
          </div>
          <!--Footer-->
          <div class="modal-footer">
            <button type="button" class="btn btn-outline-primary" data-dismiss="modal">Fermer</button>
          </div>
        </div>
      </div>
    </div>
    <!-- Modal: modalbien -->
    <!-- Modal: modalEtat -->
    <div
      class="modal fade"
      id="modalEtat"
      tabindex="-1"
      role="dialog"
      aria-labelledby="exampleModalLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <!--Header-->
          <div class="modal-header">
            <h4 class="modal-title" id="myModalLabel">Bien</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <!--Body-->
          <div class="modal-body">
            <table class="table table-hover">
              <tbody>
                <tr>
                  <th scope="row">Etat</th>
                  <td>{{dtEtat.etat}}</td>
                </tr>

                <tr>
                  <th scope="row">Murs</th>
                  <td>{{dtEtat.murs}}</td>
                </tr>
                <tr>
                  <th scope="row">Ouverture</th>
                  <td>{{dtEtat.ouverture}}</td>
                </tr>
                <tr>
                  <th scope="row">Circuit</th>
                  <td>{{dtEtat.circuit}}</td>
                </tr>
                <tr>
                  <th scope="row">Divers</th>
                  <td>{{dtEtat.divers}}</td>
                </tr>
                <tr>
                  <th scope="row">Plafonds</th>
                  <td>{{dtEtat.plafonds}}</td>
                </tr>
                <tr>
                  <th scope="row">Cuisine</th>
                  <td>{{dtEtat.cuisine}}</td>
                </tr>
                <tr>
                  <th scope="row">Salle de bain</th>
                  <td>{{dtEtat.salledebain}}</td>
                </tr>
                <tr>
                  <th scope="row">Commentaire</th>
                  <td>{{dtEtat.commentaire}}</td>
                </tr>
                  <tr>
                  <th scope="row">date</th>
                  <td>{{dtEtat.created_at | myDate}}</td>
                </tr>
              </tbody>
            </table>
          </div>
          <!--Footer-->
          <div class="modal-footer">
            <button type="button" class="btn btn-outline-primary" data-dismiss="modal">Fermer</button>
          </div>
        </div>
      </div>
    </div>
    <!-- Modal: modalEtat -->
    <div>
      <form @submit.prevent="editbien ? updateBiens() : createBiens()">
        <div class="card collapsed-card card-warning card-outline">
          <div class="card-header border-transparent">
            <h3 class="card-title">
              <font style="vertical-align: inherit;">
                <font style="vertical-align: inherit;">Ajouter Biens</font>
              </font>
            </h3>
            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-plus"></i>
              </button>
            </div>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label>Prix</label>
                  <input
                    v-model="form.prix"
                    type="text"
                    name="prix"
                    placeholder="prix"
                    class="form-control"
                    :class="{ 'is-invalid': form.errors.has('prix') }"
                  />
                  <has-error :form="form" field="prix"></has-error>
                </div>
                <!-- /.form-group -->
                <div class="form-group">
                  <label>etat</label>
                  <select
                    v-model="form.etat"
                    name="etat"
                    class="form-control"
                    :class="{ 'is-invalid': form.errors.has('etat') }"
                  >
                    <option value>selectionner un etat</option>
                    <option
                      v-for="types in typeetats.data"
                      :key="types.libelleE"
                      :value="types.id"
                    >{{types.libelleE}}</option>
                  </select>
                  <has-error :form="form" field="etat"></has-error>
                </div>

                <!-- /.form-group -->
              </div>
              <!-- /.col -->
              <div class="col-md-6">
                <div class="form-group">
                  <label>description</label>
                  <input
                    v-model="form.details"
                    type="text"
                    name="details"
                    placeholder="description"
                    class="form-control"
                    :class="{ 'is-invalid': form.errors.has('details') }"
                  />
                  <has-error :form="form" field="details"></has-error>
                </div>
                <!-- /.form-group -->
                <div class="form-group">
                  <label>adresse</label>
                  <input
                    v-model="form.adresse"
                    type="text"
                    name="adresse"
                    placeholder="adresse"
                    class="form-control"
                    :class="{ 'is-invalid': form.errors.has('adresse') }"
                  />
                  <has-error :form="form" field="adresse"></has-error>
                </div>
                <!-- /.form-group -->
              </div>
              <!-- /.col -->
            </div>
            <!-- /.row -->
            <div class="row">
              <!-- /.col -->
              <div class="col-12 col-sm-6">
                <div class="form-group">
                  <label>type de bien</label>
                  <select
                    v-model="form.type"
                    name="type"
                    class="form-control"
                    :class="{ 'is-invalid': form.errors.has('type') }"
                  >
                    <option value>selectionner un type</option>
                    <option
                      v-for="types in Typebiens.data"
                      :key="types.libelle"
                      :value="types.typebien_id"
                    >{{types.libelle}}</option>
                  </select>
                  <has-error :form="form" field="typebien_id"></has-error>
                </div>
                <!-- /.form-group -->
              </div>
              <!-- /.col -->
              <!-- /.col -->
              <div class="col-12 col-sm-6">
                <div class="form-group">
                  <label>Propriétaire</label>
                  <select
                    v-model="form.bailleur"
                    name="bailleur"
                    class="form-control"
                    :class="{ 'is-invalid': form.errors.has('bailleur') }"
                  >
                    <option value>selectionner le propriétaire</option>
                    <option value="1">alawa</option>
                    <option v-for="b in Bailleurs.data" :key="b.name" :value="b.id">{{b.name}}</option>
                  </select>
                  <has-error :form="form" field="bailleur"></has-error>
                </div>
                <!-- /.form-group -->
              </div>
              <!-- /.col -->
            </div>
            <!-- /.row -->

            <!-- /.card-body -->

            <!-- /.card -->
            <button v-if="editbien" type="submit" class="btn btn-success">Modifier</button>
            <button v-if="!editbien" type="submit" class="btn btn-primary">Ajouter</button>
          </div>
        </div>
        <!-- /.card -->
      </form>
    </div>
    <div class="card collapsed-card card-warning card-outline">
      <div class="card-header border-transparent">
        <h3 class="card-title">
          <font style="vertical-align: inherit;">
            <font style="vertical-align: inherit;">Liste Biens</font>
          </font>
        </h3>
        <div class="card-tools">
          <button type="button" class="btn btn-tool" data-card-widget="collapse">
            <i class="fas fa-plus"></i>
          </button>
        </div>
      </div>
      <!-- /.card-header -->
      <div class="card-body">
        <div class="row mt-5" v-if="$gate.isAdminOrUser()">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">liste des biens</h3>

                <div class="card-tools">

                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table id="table" class="table table-hover">
                  <thead>
                    <tr>
                      <th>Propriétaire</th>
                      <th>type</th>
                      <th>Valeur</th>
                      <th>adresse</th>
                      <th>action</th>
                      <td>Etat des lieux</td>
                      <th>Equipement</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="biens in Biens.data" :key="biens.bein_id">
                      <td>{{biens.name}}</td>
                      <td>{{biens.libelle}}</td>
                      <td>{{biens.prix}}</td>
                      <td>{{biens.adresse}}</td>
                      <td>
                        <a href="#" @click="editBien(biens)">
                          <i class="fa fa-edit blue"></i>
                        </a>
                        /
                        <a href="#" @click="deleteBiens(biens.bien_id)">
                          <i class="fa fa-trash red"></i>
                        </a>
                        /
                        <a @click="DetailBien(biens)">
                          <i class="fa fa-eye blue"></i>
                        </a>
                      </td>
                      <td>
                        <button class="btn btn-success" @click="newModalEtat(biens.bien_id)">
                          <i class="fas fa-user-plus fa fw"></i> Ajouter
                        </button>
                        <button class="btn btn-primary" @click="DetailEtat(biens.bien_id)">
                          <i class="fas fa-snowflake"></i> lister
                        </button>
                      </td>
                      <td>
                        <button class="btn btn-success" @click="newModal(biens.bien_id)">
                          <i class="fas fa-user-plus fa fw"></i> Ajouter
                        </button>
                        <button class="btn btn-primary" @click="Detail(biens.bien_id)">
                          <i class="fas fa-snowflake"></i> lister
                        </button>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
              <div class="card-footer">
                <pagination :data="Biens" @pagination-change-page="getResults"></pagination>
              </div>
            </div>
            <!-- /.card -->
          </div>
        </div>
        <!-- /.card -->
      </div>
    </div>
    <div>
      <biens-louer></biens-louer>
    </div>
    <div>
      <biens-non-louer></biens-non-louer>
    </div>
    <div v-if="!$gate.isAdminOrUser()">
      <not-found></not-found>
    </div>
    <!-- Modal -->
    <div
      class="modal fade"
      id="addNew"
      tabindex="-1"
      role="dialog"
      aria-labelledby="addNewLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" v-show="!editmode" id="addNewLabel">ajouter</h5>
            <h5 class="modal-title" v-show="editmode" id="addNewLabel">Modifier</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form @submit.prevent="editmode ? updateEquip() : createEquip()">
            <div class="modal-body">
              <div class="form-group">
                <input
                  v-model="formE.typeEquipement"
                  type="text"
                  name="typeEquipement"
                  placeholder="type Equipement"
                  class="form-control"
                  :class="{ 'is-invalid': formE.errors.has('typeEquipement') }"
                />
                <has-error :form="formE" field="typeEquipement"></has-error>
              </div>
              <div class="form-group">
                <input
                  v-model="formE.nombre"
                  type="number"
                  name="nombre"
                  placeholder="nombre"
                  class="form-control"
                  :class="{ 'is-invalid': formE.errors.has('nombre') }"
                />
                <has-error :form="formE" field="nombre"></has-error>
              </div>

              <div class="form-group">
                <label>etat</label>

                <select v-model="formE.etatEquipement" name="etatEquipement" class="form-control">
                  <option value="Bon Etat">Bon Etat</option>
                  <option value="Etat moyen">Etat moyen</option>
                  <option value=" Mauvais etat">Mauvais etat</option>
                </select>
              </div>
              <div class="form-group">
                <textarea
                  v-model="formE.commentaire"
                  type="text"
                  name="commentaire"
                  placeholder="commentaire"
                  class="form-control"
                  :class="{ 'is-invalid': formE.errors.has('commentaire') }"
                ></textarea>
                <has-error :form="formE" field="commentaire"></has-error>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-danger" data-dismiss="modal">fermer</button>
              <button v-show="editmode" type="submit" class="btn btn-success">Modifier</button>
              <button v-show="!editmode" type="submit" class="btn btn-primary">Ajouter</button>
            </div>
          </form>
        </div>
      </div>
    </div>
    <!-- Modal -->

    <!-- Modal -->
    <div
      class="modal fade"
      id="detailModal"
      tabindex="-1"
      role="dialog"
      aria-labelledby="addNewLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="addNewLabel">liste des équipements</h5>

            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <!-- /.card-header -->
            <div class="card-body table-responsive p-0" v-if="!Emode">
              <table id="table" class="table table-hover">
                <thead>
                  <tr>
                    <th>type</th>
                    <th>nombre</th>
                    <th>etat</th>
                    <th>commentaire</th>
                    <th>date</th>
                    <th>action</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="e in Equipement" :key="e.id">
                    <td>{{e.typeEquipement}}</td>
                    <td>{{e.nombreEquipement}}</td>
                    <td>{{e.etatEquipement}}</td>
                    <td>{{e.commentaireEquipement}}</td>
                    <td>{{e.created_at | myDate}}</td>

                        
                    <td>
                      <a href="#" @click="Eform(e)">
                        <i class="fa fa-edit blue"></i>
                      </a>
                      /
                      <a href="#" @click="deleteEquip(e)">
                        <i class="fa fa-trash red"></i>
                      </a>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
            <!-- /.card-body -->
            <div v-if="Emode">
              <form @submit.prevent="updateEquip()">
                <div class="modal-body">
                  <div class="form-group">
                    <input
                      v-model="formEquip.typeEquipement"
                      type="text"
                      name="typeEquipement"
                      placeholder="type Equipement"
                      class="form-control"
                      :class="{ 'is-invalid': formEquip.errors.has('typeEquipement') }"
                    />
                    <has-error :form="formEquip" field="typeEquipement"></has-error>
                  </div>
                  <div class="form-group">
                    <input
                      v-model="formEquip.nombreEquipement"
                      type="number"
                      name="nombreEquipement"
                      placeholder="nombre"
                      class="form-control"
                      :class="{ 'is-invalid': formEquip.errors.has('nombreEquipement') }"
                    />
                    <has-error :form="formEquip" field="nombreEquipement"></has-error>
                  </div>
                  <div class="form-group">
                    <label>etat</label>

                    <select
                      v-model="formEquip.etatEquipement"
                      name="etatEquipement"
                      class="form-control"
                    >
                      <option value="Bon Etat">Bon Etat</option>
                      <option value="Etat moyen">Etat moyen</option>
                      <option value=" Mauvais etat">Mauvais etat</option>
                    </select>
                  </div>

                  <div class="form-group">
                    <textarea
                      v-model="formEquip.commentaireEquipement"
                      type="text"
                      name="commentaireEquipement"
                      placeholder="commentaire"
                      class="form-control"
                      :class="{ 'is-invalid': formEquip.errors.has('commentaireEquipement') }"
                    ></textarea>
                    <has-error :form="formEquip" field="commentaireEquipement"></has-error>
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="submit" class="btn btn-success">Modifier</button>
                </div>
              </form>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">fermer</button>
          </div>
        </div>
      </div>
    </div>
    <!-- Modal -->
    <!-- Modal -->
    <div
      class="modal fade bd-example-modal-lg"
      id="detailModalEtat"
      tabindex="-1"
      role="dialog"
      aria-labelledby="myLargeModalLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="addNewLabel">les etats des lieux</h5>

            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <!-- /.card-header -->
            <div class="card-body table-responsive p-0" v-if="!Etatmode">
              <table id="table" class="table table-hover">
                <thead>
                  <tr>
                    <td>etat</td>
                    <td>murs</td>
                    <td>sols</td>
                    <td>ouverture</td>
                    <td>date</td>
                    <th>action</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="etat in Etat" :key="etat.id">
                    <td>{{etat.etat}}</td>
                    <td>{{etat.murs}}</td>
                    <td>{{etat.sols}}</td>
                    <td>{{etat.ouverture}}</td>
                    <td>{{etat.created_at | myDate}}</td>
                    <td>
                      <a href="#" @click="Etatform(etat)">
                        <i class="fa fa-edit blue"></i>
                      </a>
                      /
                      <a href="#" @click="deleteEtat(etat)">
                        <i class="fa fa-trash red"></i>
                      </a>/
                      <a href="#" @click="DTEtat(etat)">
                        <i class="fa fa-eye blue"></i>
                      </a>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
            <!-- /.card-body -->
            <div v-if="Etatmode">
              <form @submit.prevent="updateEtat()">
                <div class="modal-body">
                  <div class="form-group">
                    <label>etat</label>

                    <select v-model="formEtat.etat" name="etat" class="form-control">
                      <option value="Bon Etat">Bon Etat</option>
                      <option value="Etat moyen">Etat moyen</option>
                      <option value=" Mauvais etat">Mauvais etat</option>
                    </select>
                  </div>
                  <!-- /.form-group -->
                  <div class="form-group">
                    <label>murs</label>
                    <select v-model="formEtat.murs" name="murs" class="form-control">
                      <option value="Bon Etat">Bon Etat</option>
                      <option value="Etat moyen">Etat moyen</option>
                      <option value=" Mauvais etat">Mauvais etat</option>
                    </select>
                  </div>
                  <!-- /.form-group -->

                  <div class="form-group">
                    <label>sols</label>
                    <select v-model="formEtat.sols" name="sols" class="form-control">
                      <option value="Bon Etat">Bon Etat</option>
                      <option value="Etat moyen">Etat moyen</option>
                      <option value=" Mauvais etat">Mauvais etat</option>
                    </select>
                  </div>
                  <!-- /.form-group -->
                  <div class="form-group">
                    <label>ouverture</label>
                    <select v-model="formEtat.ouverture" name="ouverture" class="form-control">
                      <option value="Bon Etat">Bon Etat</option>
                      <option value="Etat moyen">Etat moyen</option>
                      <option value=" Mauvais etat">Mauvais etat</option>
                    </select>
                  </div>
                  <!-- /.form-group -->

                  <div class="form-group">
                    <label>circuit</label>
                    <select v-model="formEtat.circuit" name="circuit" class="form-control">
                      <option value="Bon Etat">Bon Etat</option>
                      <option value="Etat moyen">Etat moyen</option>
                      <option value=" Mauvais etat">Mauvais etat</option>
                    </select>
                  </div>
                  <!-- /.form-group -->

                  <div class="form-group">
                    <label>divers</label>
                    <select v-model="formEtat.divers" name="divers" class="form-control">
                      <option value="Bon Etat">Bon Etat</option>
                      <option value="Etat moyen">Etat moyen</option>
                      <option value=" Mauvais etat">Mauvais etat</option>
                    </select>
                  </div>
                  <!-- /.form-group -->

                  <div class="form-group">
                    <label>plafonds</label>
                    <select v-model="formEtat.plafonds" name="plafonds" class="form-control">
                      <option value="Bon Etat">Bon Etat</option>
                      <option value="Etat moyen">Etat moyen</option>
                      <option value=" Mauvais etat">Mauvais etat</option>
                    </select>
                  </div>
                  <!-- /.form-group -->

                  <div class="form-group">
                    <label>cuisine</label>
                    <select v-model="formEtat.cuisine" name="cuisine" class="form-control">
                      <option value="Bon Etat">Bon Etat</option>
                      <option value="Etat moyen">Etat moyen</option>
                      <option value=" Mauvais etat">Mauvais etat</option>
                    </select>
                  </div>
                  <!-- /.form-group -->

                  <div class="form-group">
                    <label>salle de bain</label>
                    <select v-model="formEtat.salledebain" name="salledebain" class="form-control">
                      <option value="Bon Etat">Bon Etat</option>
                      <option value="Etat moyen">Etat moyen</option>
                      <option value=" Mauvais etat">Mauvais etat</option>
                    </select>
                  </div>
                  <!-- /.form-group -->

                  <div class="form-group">
                    <label>commentaire</label>
                    <textarea
                      v-model="formEtat.commentaire"
                      name="commentaire"
                      placeholder="commentaire"
                      class="form-control"
                    ></textarea>
                  </div>
                  <!-- /.form-group -->
                </div>
                <div class="modal-footer">
                  <button type="submit" class="btn btn-success">Modifier</button>
                </div>
              </form>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">fermer</button>
          </div>
        </div>
      </div>
    </div>
    <!-- Modal -->
    <!-- Modal -->
    <div
      class="modal fade"
      id="addNewEtat"
      tabindex="-1"
      role="dialog"
      aria-labelledby="addNewLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" v-show="!editmode" id="addNewLabel">ajouter</h5>
            <h5 class="modal-title" v-show="editmode" id="addNewLabel">Modifier</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form @submit.prevent="createEtat()">
            <div class="modal-body">
              <div class="form-group">
                <label>etat</label>

                <select v-model="formEtat.etat" name="etatLieux" class="form-control">
                  <option value="Bon Etat">Bon Etat</option>
                  <option value="Etat moyen">Etat moyen</option>
                  <option value=" Mauvais etat">Mauvais etat</option>
                </select>
              </div>
              <!-- /.form-group -->
              <div class="form-group">
                <label>murs</label>
                <select v-model="formEtat.murs" name="murs" class="form-control">
                  <option value="Bon Etat">Bon Etat</option>
                  <option value="Etat moyen">Etat moyen</option>
                  <option value=" Mauvais etat">Mauvais etat</option>
                </select>
              </div>
              <!-- /.form-group -->

              <div class="form-group">
                <label>sols</label>
                <select v-model="formEtat.sols" name="sols" class="form-control">
                  <option value="Bon Etat">Bon Etat</option>
                  <option value="Etat moyen">Etat moyen</option>
                  <option value=" Mauvais etat">Mauvais etat</option>
                </select>
              </div>
              <!-- /.form-group -->
              <div class="form-group">
                <label>ouverture</label>
                <select v-model="formEtat.ouverture" name="ouverture" class="form-control">
                  <option value="Bon Etat">Bon Etat</option>
                  <option value="Etat moyen">Etat moyen</option>
                  <option value=" Mauvais etat">Mauvais etat</option>
                </select>
              </div>
              <!-- /.form-group -->

              <div class="form-group">
                <label>circuit</label>
                <select v-model="formEtat.circuit" name="circuit" class="form-control">
                  <option value="Bon Etat">Bon Etat</option>
                  <option value="Etat moyen">Etat moyen</option>
                  <option value=" Mauvais etat">Mauvais etat</option>
                </select>
              </div>
              <!-- /.form-group -->

              <div class="form-group">
                <label>divers</label>
                <select v-model="formEtat.divers" name="divers" class="form-control">
                  <option value="Bon Etat">Bon Etat</option>
                  <option value="Etat moyen">Etat moyen</option>
                  <option value=" Mauvais etat">Mauvais etat</option>
                </select>
              </div>
              <!-- /.form-group -->

              <div class="form-group">
                <label>plafonds</label>
                <select v-model="formEtat.plafonds" name="plafonds" class="form-control">
                  <option value="Bon Etat">Bon Etat</option>
                  <option value="Etat moyen">Etat moyen</option>
                  <option value=" Mauvais etat">Mauvais etat</option>
                </select>
              </div>
              <!-- /.form-group -->

              <div class="form-group">
                <label>cuisine</label>
                <select v-model="formEtat.cuisine" name="cuisine" class="form-control">
                  <option value="Bon Etat">Bon Etat</option>
                  <option value="Etat moyen">Etat moyen</option>
                  <option value=" Mauvais etat">Mauvais etat</option>
                </select>
              </div>
              <!-- /.form-group -->

              <div class="form-group">
                <label>salle de bain</label>
                <select v-model="formEtat.salledebain" name="salledebain" class="form-control">
                  <option value="Bon Etat">Bon Etat</option>
                  <option value="Etat moyen">Etat moyen</option>
                  <option value=" Mauvais etat">Mauvais etat</option>
                </select>
              </div>
              <!-- /.form-group -->

              <div class="form-group">
                <label>commentaire</label>
                <textarea
                  v-model="formEtat.commentaire"
                  name="commentaire"
                  placeholder="commentaire"
                  class="form-control"
                ></textarea>
              </div>
              <!-- /.form-group -->
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-danger" data-dismiss="modal">fermer</button>
              <button type="submit" class="btn btn-primary">Ajouter</button>
            </div>
          </form>
        </div>
      </div>
    </div>
    <!-- Modal -->
  </div>
</template>

<script>
import notFoundComponentVue from "./notFoundComponent.vue";
import BiensLouerComponent from "./BiensLouerComponent.vue";
import BiensNonLouerComponent from "./BiensNonLouerComponent.vue";
export default {
  mounted() {
    console.log("Component mounted.");
    this.getResults();
    this.type();
    this.bailleur();
    this.Equipement;
    this.getEtat();
      setTimeout(function() {
      $("#table").DataTable({
        language: {
          url: "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/French.json"
        }
      });
    }, 2000);
  },
  components: {
    "not-found": notFoundComponentVue,
    "biens-louer": BiensLouerComponent,

    "biens-non-louer": BiensNonLouerComponent
  },
  data() {
    return {
      editmode: false,
      editbien: false,
      Emode: false,
      Etatmode: false,
      Equipement: {},
      Etat: {},
      Biens: {},
      detailBien: {},
      dtEtat: {},
      formEtat: new Form({
        lieux_id: "",
        etat: "",
        murs: "",
        sols: "",
        ouverture: "",
        circuit: "",
        divers: "",
        commentaire: "",
        plafonds: "",
        cuisine: "",
        salledebain: "",
        biens: ""
      }),
      formE: new Form({
        bien_id: "",
        typeEquipement: "",
        nombre: "",
        etatEquipement: "",
        commentaire: ""
      }),
      formEquip: new Form({
        equipements_id: "",
        typeEquipement: "",
        nombreEquipement: "",
        etatEquipement: "",
        commentaireEquipement: "",
        bien: ""
      }),
      form: new Form({
        bien_id: "",
        details: "",
        prix: "",
        bailleur: "",
        etat: "",
        adresse: "",
        type: ""
      }),
      Typebiens: {},
      Bailleurs: {},
      typeetats: {}
    };
  },
  methods: {
    // Our method to GET results from a Laravel endpoint
    getResults(page = 1) {
      axios.get("api/biens?page=" + page).then(response => {
        this.Biens = response.data;
      });
    },
    getEtat(page = 1) {
      axios.get("api/typeetats?page=" + page).then(response => {
        this.typeetats = response.data;
      });
    },
    bailleur(page = 1) {
      axios.get("api/bailleurs?page=" + page).then(response => {
        this.Bailleurs = response.data;
      });
    },
    type(page = 1) {
      axios.get("api/typebiens?page=" + page).then(response => {
        this.Typebiens = response.data;
      });
    },
    updateEquip(id) {
      this.$Progress.start();
      // Submit the form via a POST request
      this.formEquip
        .put("/api/equipements/" + this.formEquip.equipements_id)
        .then(() => {
          //this will update dom automatically
          //this.loadbiens();
          Swal.fire("Deleted!", "l'équipement a bien été modifié.", "success");
          Fire.$emit("AfterCreate");
          this.$Progress.finish();
          this.Emode = false;
          this.Detail(this.formEquip.bien);
        })
        .catch(() => {
          this.$Progress.fail();
        });
    },
    deleteEquip(e) {
      Swal.fire({
        title: "etes vous sur?",
        text: "Vous ne pourrez pas revenir en arrière!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!"
      }).then(result => {
        //send ajax request to the server
        if (result.value) {
          this.formEquip
            .delete("api/equipements/" + e.equipements_id)
            .then(() => {
              Swal.fire(
                "Suppression!",
                "l'equipement a bien été supprimé.",
                "success"
              );
              Fire.$emit("AfterCreate");
              this.Emode = false;
              this.Detail(e.bien);
            })
            .catch(() => {
              swal("Failed", "Something wronge", "warnig");
            });
        }
      });
    },
    Eform(equipement) {
      console.log(equipement);
      this.Emode = true;
      this.formEquip.fill(equipement);
    },
    updateBiens(id) {
      this.$Progress.start();
      // Submit the form via a POST request
      this.form
        .put("/api/biens/" + this.form.bien_id)
        .then(() => {
          //this will update dom automatically
          //this.loadbiens();
          $("#addNew").modal("hide");
          Swal.fire("Success!", "le biens bien été modifié.", "success");
          Fire.$emit("AfterCreate");
          this.$Progress.finish();
          this.editbien = false;
          this.form.reset();
        })
        .catch(() => {
          this.$Progress.fail();
        });
    },
    editModal(equip) {
      this.editmode = true;
      this.formE.reset();
      $("#addNew").modal("show");
      this.formE.fill(equip);
    },
    editBien(bien) {
      this.editbien = true;
      this.form.reset();
      this.form.fill(bien);
      $("[data-card-widget='collapse']").click();
    },
    newModal(id) {
      this.editmode = false;
      this.formE.reset();
      $("#addNew").modal("show");
      this.formE.bien_id = id;
    },
    Detail(id) {
      axios.get("/api/biens/" + id).then(response => {
        this.Equipement = response.data.equipement;
        console.log(response.data.equipement);
      });
      $("#detailModal").modal("show");
    },

    deleteBiens(id) {
      Swal.fire({
        title: "etes vous sur?",
        text: "Vous ne pourrez pas revenir en arrière!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!"
      }).then(result => {
        //send ajax request to the server
        if (result.value) {
          this.form
            .delete("api/biens/" + id)
            .then(() => {
              Swal.fire("Deleted!", "le biens bien été supprimé.", "success");
              Fire.$emit("AfterCreate");
            })
            .catch(() => {
              swal("Failed", "Something wronge", "warnig");
            });
        }
      });
    },
    loadbiens() {
      if (this.$gate.isAdminOrUser()) {
        axios.get("/api/biens").then(({ data }) => (this.Biens = data));
      }
    },
    createBiens() {
      this.$Progress.start();
      // Submit the form via a POST request
      this.form
        .post("/api/biens")
        .then(() => {
          //this will update dom automatically
          this.loadbiens();
          //Fire.$emit("AfterCreate");

          Toast.fire({
            icon: "success",
            title: "biens a été créé avec succes"
          });
          this.$Progress.finish();
          this.form.reset();
        })
        .catch(e => {
          console.log(e);
        });
    },
    createEquip() {
      this.$Progress.start();
      // Submit the form via a POST request
      this.formE
        .post("/api/addequip")
        .then(() => {
          //this will update dom automatically
          //this.loadbiens();
          Fire.$emit("AfterCreate");
          $("#addNew").modal("hide");

          Toast.fire({
            icon: "success",
            title: "biens a été créé avec succes"
          });
          this.$Progress.finish();
        })
        .catch(e => {
          console.log(e);
        });
    },

    deleteEtat(e) {
      Swal.fire({
        title: "etes vous sur?",
        text: "Vous ne pourrez pas revenir en arrière!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!"
      }).then(result => {
        //send ajax request to the server
        if (result.value) {
          this.formEtat
            .delete("api/lieux/" + e.lieux_id)
            .then(() => {
              Swal.fire(
                "Suppression!",
                "l'equipement a bien été supprimé.",
                "success"
              );
              Fire.$emit("AfterCreate");
              this.Emode = false;
              this.Detail(e.bien);
            })
            .catch(() => {
              swal("Failed", "Something wronge", "warnig");
            });
        }
      });
    },

    Etatform(etat) {
      console.log(etat);
      this.Etatmode = true;
      this.formEtat.fill(etat);
    },
    newModalEtat(id) {
      this.formEtat.reset();
      $("#addNewEtat").modal("show");
      this.formEtat.biens = id;
    },
    DetailBien(b) {
      $("#modalCart").modal("show");
      this.detailBien = b;
    },
    DTEtat(e) {
      $("#detailModalEtat").modal("hide");
      $("#modalEtat").modal("show");
      this.dtEtat = e;
    },
    DetailEtat(id) {
      axios.get("/api/lieux/" + id).then(response => {
        this.Etat = response.data;
        console.log(response.data);
      });
      $("#detailModalEtat").modal("show");
    },
    createEtat() {
      this.$Progress.start();
      // Submit the form via a POST request
      this.formEtat
        .post("/api/lieux")
        .then(() => {
          //this will update dom automatically
          //this.loadbiens();
          Fire.$emit("AfterCreate");
          $("#addNewEtat").modal("hide");

          Toast.fire({
            icon: "success",
            title: "biens a été créé avec succes"
          });
          this.$Progress.finish();
          this.Etatmode = false;
          this.DetailEtat(this.formEtat.biens);
        })
        .catch(e => {
          console.log(e);
        });
    },
    updateEtat(id) {
      this.$Progress.start();
      // Submit the form via a POST request
      this.formEtat
        .put("/api/lieux/" + this.formEtat.lieux_id)
        .then(() => {
          //this will update dom automatically
          //this.loadbiens();
          Swal.fire("Deleted!", "l'équipement a bien été modifié.", "success");
          Fire.$emit("AfterCreate");
          this.$Progress.finish();
          this.Etatmode = false;
          this.DetailEtat(this.formEtat.biens);
        })
        .catch(() => {
          this.$Progress.fail();
        });
    },
    created() {
      this.loadbiens();
      Fire.$on("AfterCreate", () => {
        this.loadbiens();
      });
      //setInterval(()=>this.loadbiens(),10000)
    }
  }
};
</script>
