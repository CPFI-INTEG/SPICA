

<html>
	<head>
		<title>
		</title>

		<script src="https://www.gstatic.com/firebasejs/5.5.0/firebase.js"></script>
		<script>
			  // Initialize Firebase
			  var config = {
			    apiKey: "AIzaSyCNVDM6xw99wgB5zVH8Ra2pfVLENu3BKrE",
			    authDomain: "adaweb-dev.firebaseapp.com",
			    databaseURL: "https://adaweb-dev.firebaseio.com",
			    projectId: "adaweb-dev",
			    storageBucket: "",
			    messagingSenderId: "472616206277"
			  };
			  firebase.initializeApp(config);
		</script>

				<!-- Firebase App is always required and must be first -->
		<script src="https://www.gstatic.com/firebasejs/5.4.1/firebase-app.js"></script>

		<!-- Add additional services that you want to use -->
		<script src="https://www.gstatic.com/firebasejs/5.4.1/firebase-auth.js"></script>
		<script src="https://www.gstatic.com/firebasejs/5.4.1/firebase-firestore.js"></script>

		<!-- Comment out (or don't include) services that you don't want to use -->
		<!-- <script src="https://www.gstatic.com/firebasejs/5.4.1/firebase-storage.js"></script> -->

		<script>
		    firebase.initializeApp({
			  apiKey: 'AIzaSyCNVDM6xw99wgB5zVH8Ra2pfVLENu3BKrE',
			  authDomain: 'adaweb-dev.firebaseapp.com',
			  projectId: 'adaweb-dev'
			});

			// Initialize Cloud Firestore through Firebase
			var db = firebase.firestore();

			// Disable deprecated features
			db.settings({
			  timestampsInSnapshots: true
			    });

		    var fdb;
		    
		    var initFirestoreDB = function () {
		        return new Promise(function (resolve, reject) {
		            firebase.firestore().enablePersistence()
	                .then(function () {
	                    // Initialize Cloud Firestore through firebase
	                    fdb = firebase.firestore();
	                    console.log('enablePersistence done');
	                    resolve({
	                        ok: true
	                    });
	                })
	                .catch(function (err) {
	                    console.log('firestore enablePersistence error:' + err);
	                    reject(err);
	                });
		        });
		    };
		</script>



	</head>


	<body onload="InitializeFirestore()">
		<!--
		<form id="form1" >
	        <div>
	            <asp:Panel ID="Panel1" runat="server">
	                <input type="button" id="buttonConnect" onclick="dbFirestoreConnect()" value="Connect" />
	                <input type="button" id="AddUser" value="Add User" onclick="addUser()" />
	                <input type="text" id="textUser" value="" />

	            </asp:Panel>
	        </div>
	        
	            <br />
	            Enter Result:<br />
	            <input type="text" id="textboxParam" value="UID_Property1" />
	            <input type="text" id="textboxResult" />
	            <input type="button" value="Go" id="Go" onclick="postResult()" />
	            <br />
	           
	            <br />
	        
	        
	            <table class="auto-style1">
	                <tr>
	                    <td class="auto-style2">User</td>
	                    <td>
	                        <select id="dropdownUsers" onchange="requeryUser()">

	                        </select>
	                    </td>
	                </tr>
	                <tr>
	                    <td class="auto-style2">Submitted Forms</td>
	                    <td>
	                        <asp:DropDownList ID="dropdownSubmitted" runat="server" Width="305px">
	                        </asp:DropDownList>
	                    </td>
	                </tr>
	                <tr>
	                    <td class="auto-style3"></td>
	                    <td class="auto-style4"></td>
	                </tr>
	                <tr>
	                    <td class="auto-style2">&nbsp;</td>
	                    <td>&nbsp;</td>
	                </tr>
	                <tr>
	                    <td class="auto-style2">&nbsp;</td>
	                    <td>&nbsp;</td>
	                </tr>
	            </table>
	        
	    </form>

	-->
	

	<script>
        let urlParams = new URLSearchParams(window.location.search);
        let myParam = urlParams.get('myParam');

        function getParameterByName(name, url) {
	        if (!url) url = window.location.href;
	        name = name.replace(/[\[\]]/g, '\\$&');
	        var regex = new RegExp('[?&]' + name + '(=([^&#]*)|&|#|$)'),
	        results = regex.exec(url);
	        if (!results) return null;
	        if (!results[2]) return '';
	        return decodeURIComponent(results[2].replace(/\+/g, ' '));
        }



        function removeOptions(selectbox)
        {
            var i;
            for(i = selectbox.options.length - 1 ; i >= 0 ; i--)
            {
                selectbox.remove(i);
            }
        }

        function addUser() {
            //var txtUser = document.getElementById("textUser").value

            var strFirstParam="<?php echo $_GET['FirstParam']; ?>";
            var strSecondParam="<?php echo $_GET['SecondParam']; ?>";

            alert(strFirstParam);
            alert(strSecondParam);

            db.collection("users").add({
                first: strFirstParam,
                last: strSecondParam,
                born: 123
            })
                .then(function (
                    docRef) {
                    console.log("Document written with ID: ", docRef.id);
                })
                .catch(function (error) {
                    console.error("Error adding document: ", error);
                });
        }

        function InitializeFirestore(){


        	//CALL THE CONNECTION FIRST
            initFirestoreDB();



        	//DECLARE PARAMETER AND GET DATA FROM URL
            var FormName="<?php echo $_GET['FormName']; ?>";
            var FieldFirstParam="<?php echo $_GET['FieldFirstParam']; ?>";
            var FieldSecondParam="<?php echo $_GET['FieldSecondParam']; ?>";

            addData(FormName);
            //,FieldFirstParam,FieldSecondParam

        }

        function dbFirestoreConnect() { // get ALL DATA FROM FORMS TO INSERT IN SELECT TAG
            initFirestoreDB();

            var dropdownUsers = document.getElementById("dropdownUsers");
            db.collection("Users").get().then((querySnapshot) => {
             querySnapshot.forEach((doc) => {
                 console.log(`${doc.id} => ${doc.data()}`);
                    var option = document.createElement("option");
                     option.text = `${doc.id}`;
                     dropdownUsers.add(option);
                  });
            });
           // postResult();
        }

			
			


        function addData(StrFormName) {
            //DECLARE PARAMETER AND GET DATA FROM URL
            var strFirstParam="<?php echo $_GET['FirstParam']; ?>";
            var strSecondParam="<?php echo $_GET['SecondParam']; ?>";


            //ADD DATA TO FIRESTORE
            db.collection(StrFormName).add({
                param1 : strFirstParam,
                param2 : strSecondParam
            })
                .then(function (
                    docRef) {
                    console.log("Document written with ID: ", docRef.id);
                })
                .catch(function (error) {
                    console.error("Error adding document: ", error);
                });
        }

        function postResult() {
                    ///UserSubmissions/pgumpal/UID_BalanceTankMonitoring/Document_20180918_001/body/UID_Property1
           var prop = getParameterByName('prop');
            var val = getParameterByName('val');

            db.collection("/UserSubmissions/pgumpal/UID_BalanceTankMonitoring/Document_20180918_001/body").add({
                name: prop, 
                sequence: "1234",
                value: val
            })
                .then(function (
                    docRef) {
                    console.log("Document written with ID: ", docRef.id);
                    document.write(docRef.id);
                })
                .catch(function (error) {
                    console.error("Error adding document: ", error);
                });
        }


      

        function requeryUser() {

            
            var dropdownUsers = document.getElementById("dropdownSubmitted");
            var selectedUser = document.getElementById("dropdownUsers").value; 

            removeOptions(dropdownUsers);

            var getOptions = {
                source: 'default'
                // Valid options for source are 'server', 'cache', or
                // 'default'. See https://firebase.google.com/docs/reference/js/firebase.firestore.GetOptions
                // for more information.
            };

            var docRef = db.collection("UserSubmissions").doc(selectedUser).collection("UID_BalanceTankMonitoring").doc("Document_20180918_001")

           /*
            db.collection("UserSubmissions").doc(selectedUser).collection("UID_BalanceTankMonitoring").get(getOption).then((querySnapshot) => {
                querySnapshot.forEach((doc) => {
                    console.log(`${doc.id} => ${doc.data()}`);
                    var option = document.createElement("option");
                    option.text = `${doc.id}`;
                    dropdownSubmitted.add(option);
                });
            }).catch(function (error) {
                console.log("Error getting from cached doc");
            });
            */
            docRef.get(getOptions).then(function (doc) {
                console.log("Cached document data: ", doc.data());
            }).catch(function (error) {
                    console.log("Error getting cached doc:", error);
            });
       /*]]
            docRef.get().then(function (doc) {
                if (doc.exists) {
                    console.log("document data", doc.data());
                    var option = document.createElement("option");
                    option.text = `${doc.id}`;
                    dropdownSubmitted.add(option);
                }
                else {
                    console.log("no such document!");
                }
            }).catch(function (error) {
                console.log("error getting document:", error);
                }); 
          */
        }
     </script>

</body>
</html>
