//
//  ActivityTableViewController.swift
//  RevPort
//
//  Created by Odie Edo-Osagie on 17/01/2015.
//  Copyright (c) 2015 Odie Edo-Osagie. All rights reserved.
//

import UIKit

class ActivityTableViewController: UITableViewController {

    var activities = Array<PFObject>();
    
    // MARK: - View Lifecycle
    override func viewDidLoad() {
        super.viewDidLoad()
        
        /* Nav Bar */
        // Title
        var titleView = UILabel();
        titleView.text = "Recent Activities";
        titleView.font = UIFont(name: "Code-Bold", size: 16.0);
        titleView.sizeToFit();
        self.navigationItem.titleView = titleView;
        
        for item in self.tabBarController?.tabBar.items as [UITabBarItem] {
            if let image = item.image {
                item.image = image.imageWithColor(AppUtils.sharedInstance.darkGrayColour1).imageWithRenderingMode(.AlwaysOriginal)
            }
        }
        
        /* Check that a user is logged in */
        var currentUser = PFUser.currentUser();
    
        if(currentUser == nil){
            self.performSegueWithIdentifier("showLogin", sender: self);
        }
        else{
            //PFUser.logOut();
        }
        
        NSNotificationCenter.defaultCenter().addObserver(self, selector: "showLogin", name: "showLogin", object: nil);

    }
    
    func showLogin(){
        AppUtils.sharedInstance.clearCachedProperties();
        self.performSegueWithIdentifier("showLogin", sender: self);
    }
    
    override func viewWillAppear(animated: Bool) {
        super.viewWillAppear(animated);
        
        /* Show Tab bar */
        self.tabBarController?.tabBar.hidden = false;
        
        /* Make nav bar translucent rather than transparent */
        self.navigationController?.navigationBar.setBackgroundImage(nil, forBarMetrics: UIBarMetrics.Default);
        self.navigationController?.navigationBar.shadowImage = nil;
        self.navigationController?.navigationBar.translucent = true;
        
        fetchActivities();
        
        self.tabBarItem.image = UIImage(named: "checklist")?.imageWithRenderingMode(UIImageRenderingMode.AlwaysOriginal);

    }

    override func didReceiveMemoryWarning() {
        super.didReceiveMemoryWarning()
        // Dispose of any resources that can be recreated.
    }

    // MARK: - Helpers
    
    func fetchActivities(){
        
        var currentUser = PFUser.currentUser();
        if(currentUser == nil){
            return;
        }
        
        if(AppUtils.sharedInstance.cachedActivities.isEmpty){
            // clear already loaded activities
            self.activities.removeAll(keepCapacity: false);
            
            // fetch users activities
            var relation = currentUser.relationForKey("activities");
            var query = relation.query();
            query.orderByDescending("createdAt");
            query.limit = 20;
            
            query.findObjectsInBackgroundWithBlock {
                (objects: [AnyObject]!, error: NSError!) -> Void in
                if(error == nil) {
                    for object in objects {
                        var activity : PFObject = object as PFObject;
                        self.activities.append(activity);
                    }
                } else {
                    // Log details of the failure
                    NSLog("Error: %@ %@", error, error.userInfo!)
                }
                
                AppUtils.sharedInstance.cachedActivities = self.activities;
                self.tableView.reloadData();
            }
        }
        else{
            self.activities = AppUtils.sharedInstance.cachedActivities;
            self.tableView.reloadData();
            println("reload");
        }
        
    }
    
    // MARK: - Table view data source
    override func numberOfSectionsInTableView(tableView: UITableView) -> Int {
        // #warning Potentially incomplete method implementation.
        // Return the number of sections.
        return 1;
    }

    override func tableView(tableView: UITableView, numberOfRowsInSection section: Int) -> Int {
        // #warning Incomplete method implementation.
        // Return the number of rows in the section.
        return self.activities.count;
    }

    
    override func tableView(tableView: UITableView, cellForRowAtIndexPath indexPath: NSIndexPath) -> UITableViewCell {
        let cell : ActivityTableViewCell = tableView.dequeueReusableCellWithIdentifier("cell", forIndexPath: indexPath) as ActivityTableViewCell

        // Configure the cell...
        var activityMessage = self.activities[indexPath.row]["activityMessage"] as String;
        var timeOfActivity = self.activities[indexPath.row].createdAt as NSDate;
        //cell.textLabel?.text = activityMessage;
        //cell.textLabel?.numberOfLines = 0
        cell.messageLabel.textColor = AppUtils.sharedInstance.redColour1;
        cell.messageLabel.text = activityMessage;
        cell.messageLabel.sizeToFit();
        cell.messageLabel?.numberOfLines = 0
        
        //cell.timeLabel.textColor = AppUtils.sharedInstance.turqoiseColour1;
        cell.timeLabel.text = AppUtils.sharedInstance.getTimePassed(timeOfActivity);
        
        return cell
    }
    

    /*
    // Override to support conditional editing of the table view.
    override func tableView(tableView: UITableView, canEditRowAtIndexPath indexPath: NSIndexPath) -> Bool {
        // Return NO if you do not want the specified item to be editable.
        return true
    }
    */

    /*
    // Override to support editing the table view.
    override func tableView(tableView: UITableView, commitEditingStyle editingStyle: UITableViewCellEditingStyle, forRowAtIndexPath indexPath: NSIndexPath) {
        if editingStyle == .Delete {
            // Delete the row from the data source
            tableView.deleteRowsAtIndexPaths([indexPath], withRowAnimation: .Fade)
        } else if editingStyle == .Insert {
            // Create a new instance of the appropriate class, insert it into the array, and add a new row to the table view
        }    
    }
    */

    /*
    // Override to support rearranging the table view.
    override func tableView(tableView: UITableView, moveRowAtIndexPath fromIndexPath: NSIndexPath, toIndexPath: NSIndexPath) {

    }
    */

    /*
    // Override to support conditional rearranging of the table view.
    override func tableView(tableView: UITableView, canMoveRowAtIndexPath indexPath: NSIndexPath) -> Bool {
        // Return NO if you do not want the item to be re-orderable.
        return true
    }
    */

    
    
    
    
    // MARK: - Navigation
    
    // In a storyboard-based application, you will often want to do a little preparation before navigation
    override func prepareForSegue(segue: UIStoryboardSegue, sender: AnyObject?) {
        // Get the new view controller using segue.destinationViewController.
        // Pass the selected object to the new view controller.
        
        if(segue.identifier == "showLogin"){
            self.tabBarController?.tabBar.hidden = true;
        }
    }

}


