<?php

namespace App\Http\Controllers\Core;

use App\Http\Controllers\Controller;
use App\Services\ProfileService;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    protected $profileService;

    public function __construct(ProfileService $profileService)
    {
        $this->profileService = $profileService;
    }


//<form action="{{ route('profiles.add') }}" method="POST">
//@csrf
//<label>Profile Name:</label>
//<input type="text" name="profileName" required>
//
//<label>Gpsis:</label>
//<input type="text" name="AccessAndMobilitySubscriptionData[gpsis][]" value="msisdn-0900000000">
//
//<label>Default NSSAI SST:</label>
//<input type="text" name="AccessAndMobilitySubscriptionData[nssai][defaultSingleNssais][0][sst]" value="1">
//
//<label>Default NSSAI SD:</label>
//<input type="text" name="AccessAndMobilitySubscriptionData[nssai][defaultSingleNssais][0][sd]" value="010203">
//
//<button type="submit">Create Profile</button>
//</form>

    public function addProfile(Request $request)
    {
        // Check if request is JSON (AJAX)
        if ($request->isJson()) {
            $data = $request->json()->all();
        } else {
            // Convert Form Data into proper structure
            $data = [
                'profileName' => $request->input('profileName'),
                'AccessAndMobilitySubscriptionData' => [
                    'gpsis' => $request->input('AccessAndMobilitySubscriptionData.gpsis', []),
                    'nssai' => [
                        'defaultSingleNssais' => $request->input('AccessAndMobilitySubscriptionData.nssai.defaultSingleNssais', []),
                        'singleNssais' => $request->input('AccessAndMobilitySubscriptionData.nssai.singleNssais', []),
                    ],
                    'subscribedUeAmbr' => [
                        'downlink' => $request->input('AccessAndMobilitySubscriptionData.subscribedUeAmbr.downlink', '2 Gbps'),
                        'uplink' => $request->input('AccessAndMobilitySubscriptionData.subscribedUeAmbr.uplink', '1 Gbps'),
                    ]
                ],
                'SessionManagementSubscriptionData' => $request->input('SessionManagementSubscriptionData', []),
                'SmfSelectionSubscriptionData' => $request->input('SmfSelectionSubscriptionData', []),
                'AmPolicyData' => $request->input('AmPolicyData', []),
                'SmPolicyData' => $request->input('SmPolicyData', []),
                'FlowRules' => $request->input('FlowRules', []),
                'QosFlows' => $request->input('QosFlows', []),
            ];
        }

        // Validation Rules
        $request->validate([
            'profileName' => 'required|string|max:255',
            'AccessAndMobilitySubscriptionData.gpsis' => 'required|array',
            'SessionManagementSubscriptionData' => 'required|array',
            'SmfSelectionSubscriptionData' => 'required|array',
            'AmPolicyData' => 'required|array',
            'SmPolicyData' => 'required|array',
            'FlowRules' => 'required|array',
            'QosFlows' => 'required|array',
        ]);

        // Send to service
        $profile = $this->profileService->addProfile($data);

        if (!$profile) {
            return redirect()->route('profiles')->with('error', 'Failed to create profile.');
        }

        return redirect()->route('profiles')->with('success', 'Profile created successfully.');
    }

    public function updateProfile(Request $request, $profileName)
    {
        // Validate the form inputs
        $request->validate([
            'AccessAndMobilitySubscriptionData' => 'required|array',
            'SessionManagementSubscriptionData' => 'required|array',
            'SmfSelectionSubscriptionData' => 'required|array',
            'AmPolicyData' => 'required|array',
            'SmPolicyData' => 'required|array',
            'FlowRules' => 'required|array',
            'QosFlows' => 'required|array',
        ]);

        // Convert form input into structured data
        $data = [
            'AccessAndMobilitySubscriptionData' => [
                'gpsis' => $request->input('AccessAndMobilitySubscriptionData.gpsis', []),
                'nssai' => [
                    'defaultSingleNssais' => $request->input('AccessAndMobilitySubscriptionData.nssai.defaultSingleNssais', []),
                    'singleNssais' => $request->input('AccessAndMobilitySubscriptionData.nssai.singleNssais', []),
                ],
                'subscribedUeAmbr' => [
                    'downlink' => $request->input('AccessAndMobilitySubscriptionData.subscribedUeAmbr.downlink', '2 Gbps'),
                    'uplink' => $request->input('AccessAndMobilitySubscriptionData.subscribedUeAmbr.uplink', '1 Gbps'),
                ]
            ],
            'SessionManagementSubscriptionData' => $request->input('SessionManagementSubscriptionData', []),
            'SmfSelectionSubscriptionData' => $request->input('SmfSelectionSubscriptionData', []),
            'AmPolicyData' => $request->input('AmPolicyData', []),
            'SmPolicyData' => $request->input('SmPolicyData', []),
            'FlowRules' => $request->input('FlowRules', []),
            'QosFlows' => $request->input('QosFlows', []),
        ];

        // Call service to update profile
        $profile = $this->profileService->updateProfile($profileName, $data);

        if (!$profile) {
            return redirect()->route('profiles')->with('error', 'Failed to update profile.');
        }

        return redirect()->route('profiles')->with('success', 'Profile updated successfully.');
    }

    public function getAllProfiles()
    {
        $profiles = $this->profileService->getAllProfiles();

        if (!$profiles) {
            return redirect()->route('profiles')->with('error', 'Failed to fetch profiles.');
        }

        return view('profiles.index', compact('profiles'));
    }

    public function deleteProfile($profileName)
    {
        $deleted = $this->profileService->deleteProfile($profileName);

        if (!$deleted) {
            return redirect()->route('profiles')->with('error', 'Failed to delete profile.');
        }

        return redirect()->route('profiles')->with('success', 'Profile deleted successfully.');
    }
}
