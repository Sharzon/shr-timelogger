<template>
	<div>
		<button type="button" 
				class="btn btn-success btn-block"
				@click="openNewModal">Add activity</button>
		<div class="list-group" v-if="activities.length > 0">
			<a href="#" 
					class="list-group-item"
					v-for="activity in activities"
					@click="openEditModal(activity.id)">{{ activity.name }}</a>
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

export default {
	data() {
		return {
			activities: [],
			modalId: 0,
			currentDate: {}
		}
	},
	components: {
		axios,
		ModalActivity
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
			.then(response => this.activities = response.data);
		},
		openNewModal() {

		},
		openEditModal(id) {
			this.modalId = id;
			Vue.nextTick(() => this.$refs.modal.open(this.currentDate));
		},
		updateActivity(activity) {
			this.activities.forEach((curActivity, i, arr) => {
				if (activity.id == curActivity.id) {
					Vue.set(arr, i, activity);
				}
			});
		}
	},
	mounted() {
	}
}

</script>