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
			<span class="pull-right">
				End: 
				<vue-timepicker v-model="endTime"
						:minute-interval="5"
						hide-clear-button></vue-timepicker>
			</span>
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
import TPTime from './TPTime.js';
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
			startTime: new TPTime(),
			endTime: new TPTime()
		}
	},
	methods: {
		open(date) {
			this.currentDate = date;
			if (this.id) {
				axios.get('/api/activity/'+this.id, {
					params: {
						api_token: window.api_token
					}
				})
				.then(response => {
					this.activity = response.data;
					this.activity.start = new Date(this.activity.start);
					this.activity.end = new Date(this.activity.end);
					this.startTime = TPTime.dateToDPTime(this.activity.start);
					this.endTime = TPTime.dateToDPTime(this.activity.end);


					this.$refs.editModal.open();
				});
			} else {
				this.activity = {};
				this.startTime = new TPTime();
				this.endTime = new TPTime();

				this.$refs.editModal.open();
			}
		},
		save() {
			this.startTime = new TPTime(this.startTime);
			let startDT = this.startTime.toDate(this.currentDate);

			// console.log(Object.create(TPTime, this.startTime));

			// let startDT = new Date(this.currentDate.getTime());
			// startDT.setTime(startDT.getTime() + (this.startTime.HH*60 + parseInt(this.startTime.mm))*60*1000); 

			this.endTime = new TPTime(this.endTime);
			let endDT = this.endTime.toDate(this.currentDate);
			// let endDT = new Date(this.currentDate.getTime());
			// endDT.setTime(endDT.getTime() + (this.endTime.HH*60 + parseInt(this.endTime.mm))*60*1000); 

			if (endDT < startDT) {
				endDT.setTime(endDT.getTime() + 24*60*60*1000);
			}

			let result = {
				name: this.activity.name,
				start: startDT.toString(),
				end: endDT.toString(),
				api_token: window.api_token
			};

			let path = '/api/activity';
			if (this.id) {
				path += '/' + this.id;
				axios.put(path, result).then(response => {
					this.activity = response.data;
					this.activity.start = new Date(this.activity.start);
					this.activity.end = new Date(this.activity.end);

					this.$emit('save', this.activity);
				});
			} else {
				// console.log('ololo');
				axios.post(path, result).then(response => {
					this.activity = response.data;
					this.activity.start = new Date(this.activity.start);
					this.activity.end = new Date(this.activity.end);

					this.$emit('save', this.activity);
				});
			}

			// axios.put(path, result).then(response => {
			// 	this.activity = response.data;
			// 	this.$emit('save', this.activity);
			// });
			this.$refs.editModal.close();
		}
	}
}

</script>