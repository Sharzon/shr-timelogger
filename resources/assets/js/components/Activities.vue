<template>
	<div>
		<button type="button" 
				class="btn btn-success btn-block"
				@click="openNewModal">Add activity</button>
		<div v-if="activities.length > 0">
			<div v-for="activity in activities">
				<button type="button"
						@click="openEditModal(activity.id)"
						class="btn btn-primary edit-activity">
					<span class="pull-left">
						{{ activity.startStr }}
					</span>
					{{ activity.name }}
					<span class="pull-right">
						{{ activity.endStr }}
					</span>
				</button>
				<!-- </div> -->
				<!-- <div class="btn-group" role="group"> -->
				<button type="button" 
						class="pull-right btn btn-danger del-activity"
						@click="deleteActivity(activity.id)">Delete</button>
			</div>
		</div>

		<modal-activity :current-date="currentDate"
				:id="modalId" 
				ref="modal"
				@save="updateActivity"></modal-activity>
	</div>
</template>

<script>
import axios from 'axios';
import ModalActivity from './ModalActivity.vue';
import TPTime from './TPTime.js';

export default {
	data() {
		return {
			activities: [],
			modalId: null,
			currentDate: {}
		}
	},
	components: {
		axios,
		ModalActivity,
		TPTime
	},
	methods: {
		loadActivities(date) {
			this.currentDate = date;
			axios.get('/api/activity',{
				params: {
					date: date.toString(),
					api_token: window.api_token
				}
			})
			.then(response => {
				this.activities = response.data
				this.activities.forEach((activity, i, arr) => {
					activity.start = new Date(activity.start);
					activity.startStr = TPTime.dateToDPTime(activity.start).toString();
					activity.end = new Date(activity.end);
					activity.endStr = TPTime.dateToDPTime(activity.end).toString();
				});
			});
		},
		openNewModal() {
			this.modalId = null;
			Vue.nextTick(() => this.$refs.modal.open(this.currentDate));
		},
		openEditModal(id) {
			this.modalId = id;
			Vue.nextTick(() => this.$refs.modal.open(this.currentDate));
		},
		updateActivity(activity) {
			activity.startStr = TPTime.dateToDPTime(activity.start).toString();
			activity.endStr = TPTime.dateToDPTime(activity.end).toString();


			let removableIndex = this.activities.length;
			for (let i = 0; i < this.activities.length; i++) {
				if (activity.id == this.activities[i].id) {
					removableIndex = i;
					break;
				}
			}
			this.activities.splice(removableIndex, 1);

			let insertableIndex = this.activities.length;
			for (let i = 0; i < this.activities.length; i++) {
				if (activity.start < this.activities[i].start) {
					insertableIndex = i;
					break;
				}
			}
			this.activities.splice(insertableIndex, 0, activity);

			// this.activities.forEach((curActivity, i, arr) => {
			// 	if (activity.id == curActivity.id) {
			// 		Vue.set(arr, i, activity);
			// 	}
			// });
		},
		deleteActivity(id) {
			axios.delete('/api/activity/'+id, {
				params: {
					api_token: window.api_token
				}
			}).then(response => {
				let removableIndex = this.activities.length;
				for (let i = 0; i < this.activities.length; i++) {
					if (id == this.activities[i].id) {
						removableIndex = i;
						break;
					}
				}

				this.activities.splice(removableIndex, 1);
			});
		}
	},
	mounted() {

	}
}

</script>

<style>
	.edit-activity {
		width: 85%;
	}
	.del-activity {
		width: 15%;
	}
</style>