class TPTime {

  constructor(hours, minutes) {
    if (arguments.length == 1) {
      this.HH = arguments[0].HH;
      this.mm = arguments[0].mm;
    } else if (hours !== undefined && minutes !== undefined) {
      this.HH = TPTime.numTo00Format(hours);
      this.mm = TPTime.numTo00Format(minutes);
    } else {
      this.HH = "00";
      this.mm = "00";
    }
  }

  toDate(startingDate) {
    let date = new Date(startingDate.getTime());
    date.setHours(parseInt(this.HH));
    date.setMinutes(parseInt(this.mm));
    
    return date;
  }

  toString() {
    return TPTime.numTo00Format(this.HH) + ':' + TPTime.numTo00Format(this.mm);
  }

  static numTo00Format(num) {
    let str = '' + num;
    if (str.length == 1) {
      str = '0' + str;
    }

    return str;
  }

  static dateToDPTime(date) {
    return new TPTime(date.getHours(), date.getMinutes());
  }

}

export default TPTime;