<template>

<bootstrap-modal ref="editModal" :needHeader="false" :needFooter="true">
	<div slot="body">

		<div class="form-group">
			<label for="name">Activity name</label>
			<input class="form-control" 
					type="text" 
					name="name"
					v-model="activity.name">
		</div>
		<div>
			Start: 
			<vue-timepicker v-model="startTime"
					:minute-interval="5"
					hide-clear-button></vue-timepicker>
		</div>
		<div>
			End: 
			<vue-timepicker v-model="endTime"
					:minute-interval="5"
					hide-clear-button></vue-timepicker>
		</div>
	</div>
	<div slot="footer">
		<button type="button" 
				class="btn btn-default"
				@click="$refs.editModal.close()">Cancel</button>
		<button type="button" 
				class="btn btn-primary"
				@click="save">Save</button>
	</div>
</bootstrap-modal>

</template>

<script>
import VueTimepicker from 'vue2-timepicker';
import BootstrapModal from 'vue2-bootstrap-modal';
import axios from 'axios'

export default {
	props: {
		id: Number
	},
	components: {
		BootstrapModal,
		VueTimepicker
	},
	data() {
		return {
			currentDate: {},
			activity: {},
			title: 'Add activity',
			startTime: {
				HH: 0,
				mm: 0
			},
			endTime: {
				HH: 0,
				mm: 0
			}
		}
	},
	methods: {
		open(date) {
			this.currentDate = date;
			axios.get('/api/activity/'+this.id, {
				params: {
					api_token: window.api_token
				}
			})
			.then(response => {
				this.activity = response.data;
				this.activity.start = new Date(this.activity.start);
				this.activity.end = new Date(this.activity.end);
				this.startTime = this.dateToDPTime(this.activity.start);
				this.endTime = this.dateToDPTime(this.activity.end);


				this.$refs.editModal.open();
			});
		},
		save() {
			let startDT = new Date(this.currentDate.getTime());
			startDT.setTime(startDT.getTime() + (this.startTime.HH*60 + parseInt(this.startTime.mm))*60*1000); 

			let endDT = new Date(this.currentDate.getTime());
			endDT.setTime(endDT.getTime() + (this.endTime.HH*60 + parseInt(this.endTime.mm))*60*1000); 

			if (endDT < startDT) {
				endDT.setTime(endDT.getTime() + 24*60*60*1000);
			}

			axios.put('/api/activity/'+this.id, {
				name: this.activity.name,
				start: startDT.toString(),
				end: endDT.toString(),
				api_token: window.api_token
			})
			.then(response => {
				this.activity = response.data;
				this.$emit('save', this.activity);
			});
			this.$refs.editModal.close();
		},
		DPTimeToDate(datepickerTime) {

		},
		dateToDPTime(date) {
			return {
				HH: ''+date.getHours(),
				mm: ''+date.getMinutes()
			}
		}

	}
}

</script>