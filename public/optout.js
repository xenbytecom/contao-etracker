function initTrackingCheckBox(id) {
  const checkBox = document.getElementById(id);
  checkBox.checked = _etracker.isTrackingEnabled();
  checkBox.onclick = function () {
    const tld = this.getAttribute('data-tld');
    this.checked ? _etracker.enableTracking(tld) : _etracker.disableTracking(tld);
  };
}

_etrackerOnReady.push(function() {
  initTrackingCheckBox('trackingAllowed');
});
